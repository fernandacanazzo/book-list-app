<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m231228_172256_create_table_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'author' => $this->string()->notNull(),
            'number_of_pages' => $this->integer(5)->notNull(),
            'date_insert' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
