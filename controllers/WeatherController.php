<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;

class WeatherController extends Controller
{   

    public $enableCsrfValidation = false;

    public function behaviors() {

        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'login',
                'refresh-token',
                'index',
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
        $behaviors['authenticator']['except'] = ['index'];

        return $behaviors;

    }

    public function actionIndex(){

       $apiKey = Yii::$app->params['apiKey'];
        $location = json_decode(file_get_contents("https://api.hgbrasil.com/geoip?key=".$apiKey."&address=remote&precision=false"),true);
        $woeid = $location['results']['woeid'];

        $weatherData = json_decode(file_get_contents('https://api.hgbrasil.com/weather?woeid='.$woeid),true);
        
        return json_encode(
            array(
                "city"=>$weatherData['results']['city'],
                "temperature"=>$weatherData['results']['temp'],
                "condition_slug"=>$weatherData['results']['condition_slug']
            )
        );

    }

}