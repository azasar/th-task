<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transfer`.
 */
class m180425_123337_create_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transfer', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'amount' => $this->double(2)->notNull(),
            'create_date' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP')
                ->notNull(),
        ]);

        $this->addForeignKey('fk_transfer_sender_id', 'transfer', 'sender_id', 'user', 'id');
        $this->addForeignKey('fk_transfer_recipient_id', 'transfer', 'recipient_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transfer');
    }
}
