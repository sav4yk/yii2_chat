<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat}}`.
 */
class m201023_090208_create_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->string()->notNull(),
            'visible' => $this->boolean()->defaultValue(true),
            'created_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            'idx-chat-user_id',
            'chat',
            'user_id'
        );

        $this->addForeignKey(
            'fk-chat-user_id',
            'chat',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-chat-user_id', 'chat');

        $this->dropIndex('idx-chat-user_id', 'chat');

        $this->dropTable('chat');
    }
}
