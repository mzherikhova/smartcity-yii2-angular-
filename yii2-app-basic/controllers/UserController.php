<?php

namespace app\controllers;

use Yii; 
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\User;
use yii\helpers\ArrayHelper;
 
class UserController extends Controller
{
    
    public function behaviors()
    {
       $behaviors = parent::behaviors();
       $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' =>['getusers']          
        ];
       $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],                
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];
       $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['getusers'],
            'rules' => [
                [
                    'actions' => ['getusers'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
       return $behaviors;
    } 
    
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->token,'admin'=>Yii::$app->user->can("admin")];
        } else {
            $model->validate();
            return $model;
        }
    }   
    
}
