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
class UserRefreshToken extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_refresh_tokens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['urf_userID', 'urf_token', 'urf_ip','urf_user_agent'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        
    }
}