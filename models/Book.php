<?php

namespace app\models;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property string $title
 * @property string $author
 * @property text $description
 * @property integer $number_of_pages
 * @property date $date_insert
 */
class Book extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'author', 'description'], 'required'],
            [['number_of_pages'], 'integer'],
            [['date_insert'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'number_of_pages' => 'Number Of Pages',
            'date_insert' => 'Insert Date',
        ];
    }
}