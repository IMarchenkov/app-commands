<?php

use yii\db\Migration;

/**
 * Class m190716_063356_change_user_table
 */
class m190716_063356_change_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string()->notNull());
        $this->addColumn('{{%user}}', 'length_password', $this->integer()->notNull());

        $this->renameColumn('{{%user}}', 'username', 'login');

        $this->createIndex('ix_user_email', '{{%user}}', 'email');
        $this->createIndex('ix_user_verification_token', '{{%user}}', 'verification_token');
        $this->createIndex('ix_user_status', '{{%user}}', 'status');
        $this->createIndex('ix_user_access_token', '{{%user}}', 'access_token');
        $this->createIndex('ix_user_login', '{{%user}}', 'login');
        $this->createIndex('ix_user_password_reset_token', '{{%user}}', 'password_reset_token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('ix_user_email', '{{%user}}');
        $this->dropIndex('ix_user_verification_token', '{{%user}}');
        $this->dropIndex('ix_user_status', '{{%user}}');
        $this->dropIndex('ix_user_access_token', '{{%user}}');
        $this->dropIndex('ix_user_login', '{{%user}}');
        $this->dropIndex('ix_user_password_reset_token', '{{%user}}');

        $this->renameColumn('{{%user}}', 'login', 'username');

        $this->dropColumn('{{%user}}', 'length_password');
        $this->dropColumn('{{%user}}', 'access_token');
    }
}
