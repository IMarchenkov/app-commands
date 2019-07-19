<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%board}}`.
 */
class m190719_062716_create_board_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%board}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk_board_user', 
            '{{%board}}', 
            'user_id', 
            'user', 
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_board_user',
            '{{%board}}'
        );

        $this->dropTable('{{%board}}');
    }
}
