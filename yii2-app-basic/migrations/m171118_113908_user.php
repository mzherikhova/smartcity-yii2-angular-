<?php

use yii\db\Migration;
use app\models\User;
/**
 * Class m171118_113908_user
 */
class m171118_113908_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'auth_key' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'oauth_client' => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'logged_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

    
        $this->insert('user',array(
            'email'=>'admin@test.ru',
            'username' =>'admin',
            'password' => md5('admin'),
            'access_token' => 'sPgE6hjDStHpk4WhPH0J6COlf-wP-kMv'
          ));
          $this->insert('user',array(
            'email'=>'usern@test.ru',
            'username' =>'user',
            'password' => md5('user'),
            'access_token' => 'E1x5g9jRMXd2LB7CuMZmrY7hkQT-cyQK'
          ));
        
    }

    public function safeDown()
    {
       
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171118_113908_user cannot be reverted.\n";

        return false;
    }
    */
}
