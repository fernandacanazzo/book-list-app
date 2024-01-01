<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\Book;

class BookController extends Controller
{   

    public $enableCsrfValidation = false;

    public function behaviors() {

        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'login',
                'refresh-token',
                'options',
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

        return $behaviors;

    }

    public function actionCreate()
    {

        $request = \Yii::$app->request->getRawBody();
		$arrRequest = json_decode($request, true);
		
        $book = new Book();
        $book->title = $arrRequest['title'];
        $book->author = $arrRequest['description'];
        $book->description = $arrRequest['author'];
        $book->number_of_pages = $arrRequest['number_of_pages'];
        $book->date_insert = date("Y-m-d");

        $response = new Response();
        $response->headers->set('Access-Control-Allow-Headers','content-type');
        $response->headers->set('Access-Control-Allow-Origin','*');

        if($book->validate()){

            $book->save();
           
            $response->data = json_encode(array("message"=>"Book was successfully created."));
            return $response;

        }else{

            $response->statusCode = 500;
            $response->data = json_encode(array("message"=>$book->errors));
            return $response;

        }

    }

    public function actionUpdate($id)
    {

        $request = \Yii::$app->request->getRawBody();
        $request = (string)$request;
		$arrRequest = json_decode($request, true);
		$arrRequest["date_insert"] = date("Y-m-d");

        $book = Book::findOne($id);

        $response = new Response();
        $response->headers->set('Access-Control-Allow-Headers','content-type');
        $response->headers->set('Access-Control-Allow-Origin','*');

        if($book){

            $book->attributes = $arrRequest;

            if($book->validate()){

                $book->save();

                $response->data = json_encode(array("message"=>"Book was successfully updated."));
                return $response;

            }else{

                $response->statusCode = 500;
                $response->data = json_encode(array("message"=>$book->errors));
                return $response;

            }

        }else{

            $response->statusCode = 500;
            $response->data = json_encode(array("message"=>"Book #id {$id} doesn't exist."));
            return $response;

        }
    }

    public function actionDelete($id)
    {
		
		if(\Yii::$app->request->getMethod() == 'DELETE'){
			
			$id = (int)$id;
			$bookExists = false;
			
			$book = Book::findOne($id);
						
			if($book)
				$bookExists = true;
			
			$response = new Response();
			$response->headers->set('Access-Control-Allow-Headers','content-type');
			$response->headers->set('Access-Control-Allow-Origin','*');
		
			if($bookExists && $book->delete()){
				
				$response->data = json_encode(array("message"=>"Book was successfully deleted"));
				return $response;

			}elseif(!$bookExists){

				$response->statusCode = 500;
				$response->data = json_encode(array("message"=>"Book doesn't exist"));
				return $response;

			}else{
				
				$response->statusCode = 500;
				$response->data = json_encode(array("message"=>"Error on delete action"));
				return $response;
				
			}
		
		}

    }

    public function actionIndex()
    {
     
        $books = Book::find()->orderBy(['id' => SORT_DESC])->asArray()->all();

        foreach($books as $key => $book){

            $date_format = date_format(date_create($book['date_insert']),"m/d/Y");
            $books[$key]['date_insert'] = $date_format;

        }

        $response = new Response();
        $response->headers->set('Access-Control-Allow-Headers','content-type');
        $response->headers->set('Access-Control-Allow-Origin','*');

        if($books){

            $response->data = json_encode($books);
            return $response;

        }else{

            $response->data = json_encode(array("message"=>"Book table is empty."));
            return $response;

        }

    }

}