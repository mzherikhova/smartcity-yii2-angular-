<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
   

    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    const ROLE_USER = 'user';
    const ROLE_ADMINISTRATOR = 'admin';

    /**
     * @inheritdoc
     */     
     
    public static function tableName()
    {
        return '{{%user}}';
    }
     
    public static function findIdentity($id) {
        $user = self::find()
                ->where([
                    "id" => $id
                ])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }
     
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $userType = null) {
     
        $user = self::find()
                ->where(["access_token" => $token])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }
     
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $user = self::find()
                ->where([
                    "username" => $username
                ])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }
     
    public static function findByUser($username) {
        $user = self::find()
                ->where([
                    "username" => $username
                ])
                ->one();
        if (!count($user)) {
            return null;
        }
        return $user;
    }
     
    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }
     
    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }
    
    public function getToken() {
        return $this->access_token;
    
    } 
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }
     
    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {       
        return $this->password ===  md5($password);
    }
}
