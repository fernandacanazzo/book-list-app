<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\Book;

class BookController extends Controller
{   

    //public $enableCsrfValidation = false;

    //user has to be authenticated
    public function behaviors()
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
    }

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

        if($book->validate()){

            $book->save();

            $response = new Response();
            $response->data = json_encode(array("message"=>"Book was successfully created."));
            return $response;

        }else{

            $response = new Response();
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

        if($book){

            $book->title = $request['title'];
            $book->author = $request['author'];
            $book->description = $request['description'];
            $book->number_of_pages = $request['number_of_pages'];
            $book->date_insert = $request['date_insert'];

            if($book->validate()){

                $book->save();

                $response = new Response();
                $response->data = json_encode(array("message"=>"Book was successfully updated."));
                return $response;

            }else{

                $response = new Response();
                $response->statusCode = 500;
                $response->data = json_encode(array("message"=>$book->errors));
                return $response;

            }

        }else{

            $response = new Response();
            $response->statusCode = 500;
            $response->data = json_encode(array("message"=>"Book #id {$id} doesn't exist."));
            return $response;

        }
    }

    public function actionDelete($id)
    {
     
        $book = Book::findOne($id);

        if($book && $book->delete()){

            $response = new Response();
            $response->data = json_encode(array("message"=>"Book was successfully deleted."));
            return $response;

        }else{

            $response = new Response();
            $response->statusCode = 500;
            $response->data = json_encode(array("message"=>"Error on delete action"));
            return $response;

        }

    }

    public function actionIndex()
    {
     
        $books = Book::find()->asArray()->all();

        if($books){

            $response = new Response();
            $response->data = json_encode(array("books"=>$books));
            return $response;

        }else{

            $response = new Response();
            $response->statusCode = 500;
            $response->data = json_encode(array("message"=>"Book table is empty."));
            return $response;

        }

    }

}