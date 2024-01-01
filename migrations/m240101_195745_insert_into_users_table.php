<?php

use yii\db\Migration;

/**
 * Class m240101_195745_insert_into_users_table
 */
class m240101_195745_insert_into_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {   
        //example users
        $this->batchInsert('user', ['username', 'password'], [
            ['admin', password_hash("admin", PASSWORD_DEFAULT)],
            ['user1', password_hash("user1", PASSWORD_DEFAULT)],
            ['user2', password_hash("user2", PASSWORD_DEFAULT)]
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240101_195745_insert_into_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240101_195745_insert_into_users_table cannot be reverted.\n";

        return false;
    }
    */
}
