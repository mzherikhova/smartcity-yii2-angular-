<?php

use yii\db\Migration;

/**
 * Class m171117_192457_init_rbac
 */
class m171117_192457_init_rbac extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        $createPost = $auth->createPermission('createOrder');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updateOrder');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createPost);

       
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $user);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }
    
    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171117_192457_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
