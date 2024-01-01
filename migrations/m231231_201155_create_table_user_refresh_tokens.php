<?php

use yii\db\Migration;

/**
 * Class m231231_201155_create_table_user_refresh_tokens
 */
class m231231_201155_create_table_user_refresh_tokens extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%user_refresh_tokens}}', [
            'user_refresh_tokenID' => $this->primaryKey(),
            'urf_userID' => $this->integer(10)->notNull(),
            'urf_token' => $this->text()->notNull(),
            'urf_ip' => $this->string(50)->notNull(),
            'urf_user_agent' => $this->text()->notNull(),
            'urf_created' => $this->dateTime(),           
        ]);

        $this->addForeignKey(
            'fk-user_refresh_tokens-urf_userID',
            'user_refresh_tokens',
            'urf_userID',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_refresh_tokens}}');

        $this->dropForeignKey(
            'fk-user_refresh_tokens-urf_userID',
            'user_refresh_tokens'
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231231_201155_create_table_user_refresh_tokens cannot be reverted.\n";

        return false;
    }
    */
}
