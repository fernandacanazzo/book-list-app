<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\Book;

class BookController extends Controller
{   

    public $enableCsrfValidation = false;

    //user has to be authenticated
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }*/

    public function actionCreate()
    {

        $request = \Yii::$app->request;
        $request = json_decode($request->getRawBody(), true)[0];

        $book = new Book();
        $book->title = $request['title'];
        $book->author = $request['author'];
        $book->description = $request['description'];
        $book->number_of_pages = $request['number_of_pages'];
        $book->date_insert = $request['date_insert'];

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

        $request = \Yii::$app->request;        
        $request = json_decode($request->getRawBody(), true)[0];

        $book = Book::findOne($id);

        $response = new Response();
        $response->headers->set('Access-Control-Allow-Headers','content-type');
        $response->headers->set('Access-Control-Allow-Origin','*');

        if($book){

            $book->title = $request['title'];
            $book->author = $request['author'];
            $book->description = $request['description'];
            $book->number_of_pages = $request['number_of_pages'];
            $book->date_insert = $request['date_insert'];

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
     
        $book = Book::findOne($id);

        $response = new Response();
        $response->headers->set('Access-Control-Allow-Headers','content-type');
        $response->headers->set('Access-Control-Allow-Origin','*');

        if($book && $book->delete()){

            $response->data = json_encode(array("message"=>"Book was successfully deleted."));
            return $response;

        }else{

            $response->statusCode = 500;
            $response->data = json_encode(array("message"=>"Error on delete action"));
            return $response;

        }

    }

    public function actionIndex()
    {
     
        $books = Book::find()->asArray()->all();

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

            $response->statusCode = 500;
            $response->data = json_encode(array("message"=>"Book table is empty."));
            return $response;

        }

    }

}