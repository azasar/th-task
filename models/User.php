<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use \yii\web\IdentityInterface;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property double $balance
 * @property double $availableBalanceForTransfer
 * @property int $created_at [timestamp]
 * @property int $updated_at [timestamp]
 * @property string $auth_key [varchar(32)]
 * @property int $create_date [timestamp]
 * @property int $update_date [timestamp]
 */
class User extends ActiveRecord implements IdentityInterface
{
    const CREDIT_LIMIT = -1000;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username'], 'required'],
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
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     * @throws NotSupportedException
     */
    public function validatePassword($password)
    {
        throw new NotSupportedException('"validatePassword" is not implemented.');
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @throws NotSupportedException
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @throws NotSupportedException
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getIncomeTransfers()
    {
        return $this->hasMany(Transfer::class, ['recipient_id' => 'id']);
    }

    public function getOutcomeTransfers()
    {
        return $this->hasMany(Transfer::class, ['sender_id' => 'id']);
    }

    public function getBalance()
    {
        $incomes = doubleval($this->getIncomeTransfers()->sum('amount'));
        $outcomes = doubleval($this->getOutcomeTransfers()->sum('amount'));
        return $incomes - $outcomes;
    }

    public static function create($username)
    {
        $user = new self();
        $user->username = $username;
        $user->generateAuthKey();

        return $user;
    }

    public function hasEnoughBalance($amount)
    {
        return $this->getAvailableBalanceForTransfer() >= $amount;
    }

    public function getAvailableBalanceForTransfer()
    {
        return $this->balance - self::CREDIT_LIMIT;
    }
}
