<?php

namespace app\models;


use Yii;
use yii\db\ActiveRecord;


class Order extends ActiveRecord
{
    const STATUS_CREATED = 1;
    const STATUS_COMPLITED = 2;
    const STATUS_DELETED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','price'], 'required'],            
            
        ];
    }

    /**
     * @inheritdoc
     */
   public function formName()
    {
        return '';
    }

    

    
}