<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\Transfer]].
 *
 * @see \app\models\Transfer
 */
class TransferQuery extends \yii\db\ActiveQuery
{
    public function forUser($userId)
    {
        return $this->andWhere([
            'OR',
            ['sender_id' => $userId],
            ['recipient_id' => $userId]
        ]);
    }
}
