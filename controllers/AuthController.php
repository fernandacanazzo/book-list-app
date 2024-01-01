<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\User;

class AuthController extends Controller
{   

    public $enableCsrfValidation = false;

    public function behaviors() {

    	$behaviors = parent::behaviors();

		$behaviors['authenticator'] = [
			'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
			'except' => [
				'create',
				'refresh-token',
				'options',
				'login'
			],
		];

		// remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        
        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];
        $behaviors['authenticator']['except'] = ['create'];

		return $behaviors;

	}

	private function generateJwt($user_id) {

		$jwt = Yii::$app->jwt;
		$signer = $jwt->getSigner('HS256');
		$key = $jwt->getKey();
		$time = time();
		$jwtParams = Yii::$app->params['jwt'];
		//dd($signer);
		return $jwt->getBuilder()
			->issuedBy($jwtParams['issuer'])
			->permittedFor($jwtParams['audience'])
			->identifiedBy($jwtParams['id'], true)
			->issuedAt($time)
			->expiresAt($time + $jwtParams['expire'])
			->withClaim('uid', $user_id)
			->sign($signer,$key)
			->getToken($signer, $key);
	}

	/**
	 * @throws yii\base\Exception
	 */
	private function generateRefreshToken($user_id, \app\models\User $impersonator = null): \app\models\UserRefreshToken {
		$refreshToken = Yii::$app->security->generateRandomString(200);
		//dd($user_id);
		// TODO: Don't always regenerate - you could reuse existing one if user already has one with same IP and user agent
		$userRefreshToken = new \app\models\UserRefreshToken([
			'urf_userID' => $user_id,
			'urf_token' => $refreshToken,
			'urf_ip' => Yii::$app->request->userIP,
			'urf_user_agent' => Yii::$app->request->userAgent,
			'urf_created' => gmdate('Y-m-d H:i:s'),
		]);

		if (!$userRefreshToken->save()) {
			throw new \yii\web\ServerErrorHttpException('Failed to save the refresh token');
		}

		// Send the refresh-token to the user in a HttpOnly cookie that Javascript can never read and that's limited by path
		Yii::$app->response->cookies->add(new \yii\web\Cookie([
			'name' => 'refresh-token',
			'value' => $refreshToken,
			'httpOnly' => true,
			'sameSite' => 'none',
			'secure' => true,
			'path' => '/v1/auth/refresh-token',  //endpoint URI for renewing the JWT token using this refresh-token, or deleting refresh-token
		]));

		return $userRefreshToken;
	}

	public function actionRefreshToken() {
		$refreshToken = Yii::$app->request->cookies->getValue('refresh-token', false);
		if (!$refreshToken) {
			return new \yii\web\UnauthorizedHttpException('No refresh token found.');
		}

		$userRefreshToken = \app\models\UserRefreshToken::findOne(['urf_token' => $refreshToken]);

		if (Yii::$app->request->getMethod() == 'POST') {
			// Getting new JWT after it has expired
			if (!$userRefreshToken) {
				return new \yii\web\UnauthorizedHttpException('The refresh token no longer exists.');
			}

			$user = \app\models\User::find()  //adapt this to your needs
				->where(['id' => $userRefreshToken->urf_userID])
				->one();
			if (!$user) {
				$userRefreshToken->delete();
				return new \yii\web\UnauthorizedHttpException("The user doesn't exist");
			}

			$token = $this->generateJwt($user);

			return [
				'status' => 'ok',
				'token' => (string) $token,
			];

		} elseif (Yii::$app->request->getMethod() == 'DELETE') {
			// Logging out
			if ($userRefreshToken && !$userRefreshToken->delete()) {
				return new \yii\web\ServerErrorHttpException('Failed to delete the refresh token.');
			}

			return ['status' => 'ok'];
		} else {
			return new \yii\web\UnauthorizedHttpException('The user is inactive.');
		}
	}

	public function actionCreate(){

		if (Yii::$app->request->getMethod() == 'POST') {

			$request = \Yii::$app->request->getRawBody();
        	$request = (string)$request;
			$arrRequest = json_decode($request, true);

			$user = User::findByUsername($arrRequest['username']);

			$response = new Response();
			$response->headers->set('Access-Control-Allow-Headers','content-type');
        	$response->headers->set('Access-Control-Allow-Origin','*');

			if($user && password_verify($arrRequest['password'], $user->oldAttributes['password'])){

				$token = $this->generateJwt($user->oldAttributes['id']);
				$this->generateRefreshToken($user->oldAttributes['id']);

				$response->statusCode = 200;
				$response->data = json_encode([
					'token' => (string) $token,
					"status"=>$response->statusCode
				]);

			}else{

				$response->statusCode = 401;
                $response->data = json_encode(array("message"=>"Authorization failed, invalid credentials", "status"=>$response->statusCode));

			}

			return $response;

		}
		
	}

}