<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m201023_080918_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string(255)->notNull(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'photo' => $this->string()->notNull(),
            'isAdmin' => $this->boolean()->defaultValue(false)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
