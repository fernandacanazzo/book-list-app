<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m231228_172256_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
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
        $this->dropTable('{{%books}}');
    }
}
