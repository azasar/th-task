<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180425_113039_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'create_date' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP')
                ->notNull(),
            'update_date' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
                ->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
