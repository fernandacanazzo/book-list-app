<?php

namespace app\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface{


    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    /*private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/

    public static function tableName()
    {
        return 'user';
    }


    public function rules()
    {
        return [
            [['id', 'username', 'password'], 'required'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
       // dd($token);
        return static::find()
            ->where(['id' => (string) $token->getClaim('uid') ])
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->where(['username' => (string)$username])
            ->one();

    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function afterSave($isInsert, $changedOldAttributes) {
        // Purge the user tokens when the password is changed
        if (array_key_exists('password', $changedOldAttributes)) {
            \app\models\UserRefreshToken::deleteAll(['urf_userID' => $this->userID]);
        }

        return parent::afterSave($isInsert, $changedOldAttributes);
    }
}
