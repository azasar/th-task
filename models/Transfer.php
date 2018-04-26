<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfer".
 *
 * @property int $id
 * @property int $sender_id
 * @property int $recipient_id
 * @property double $amount
 * @property string $create_date
 *
 * @property User $recipient
 * @property User $sender
 */
class Transfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_id', 'recipient_id', 'amount'], 'required'],
            [['sender_id', 'recipient_id'], 'integer'],
            [['amount'], 'number'],
            [['create_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_id' => Yii::t('app', 'Sender'),
            'recipient_id' => Yii::t('app', 'Recipient'),
            'amount' => Yii::t('app', 'Amount'),
            'create_date' => Yii::t('app', 'Create Date'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\queries\TransferQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\TransferQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    public static function create($senderId, $recipientId, $amount)
    {
        $transfer = new self();
        $transfer->sender_id = $senderId;
        $transfer->recipient_id = $recipientId;
        $transfer->amount = $amount;

        return $transfer;
    }
}
