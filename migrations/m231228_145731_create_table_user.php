<?php

use yii\db\Migration;

/**
 * Class m231228_145731_create_table_user
 */
class m231228_145731_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull(),
            'password' => $this->string(80)->notNull(),
            'auth_key' => $this->string(80),
            'access_token' => $this->string(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231228_145731_create_table_users cannot be reverted.\n";

        return false;
    }
    */
}
