<?php

use yii\db\Migration;
use app\models\Order;

/**
 * Class m171118_120941_order
 */
class m171118_120941_order extends Migration
{
    /**
     * @inheritdoc
     */
   public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),           
            'price' => $this->money(10, 2),
            'status' => $this->smallInteger()->notNull()->defaultValue(Order::STATUS_CREATED),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_order_user',
            '{{%order}}',
            'user_id',
            '{{%user}}',
            'id',
            'set null',
            'cascade'
        );

        
    }

    public function safeDown()
    {
       
        $this->dropTable('{{%order}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171118_120941_order cannot be reverted.\n";

        return false;
    }
    */
}
