<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;

class LoginController extends Controller
{   

    public $enableCsrfValidation = false;

    public function actionCreate(){

        return json_encode(
            array(
                "token"=>"testtoken12345"
            )
        );

    }

}