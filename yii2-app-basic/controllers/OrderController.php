<?php

namespace app\controllers;
 
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\User;
use yii\helpers\ArrayHelper;

 
class OrderController extends ActiveController
{
    // указываем класс модели, который будет использоваться
    public $modelClass = 'app\models\Order';
 
    public function behaviors()
    {
       $behaviors = parent::behaviors();
       $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['index','create','update','delete','view'],
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
       
       return $behaviors;
    } 
    
    
    public function actions() 
    { 
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider() 
    {
        $searchModel = new \app\models\OrderSearch();    
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
    
    public function actionGetusers()
    {
        echo json_encode(['users'=>ArrayHelper::map(User::find()->orderBy(['id'=>SORT_ASC])->all(),'id', 'username')]);
    }
        
}