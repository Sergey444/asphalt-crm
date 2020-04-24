<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%partner}}`.
 */
class m200424_175655_create_partner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%partner}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'director_name' => $this->string(),
            'contact_name' => $this->string(),
            'site' => $this->string(),
            'inn' => $this->integer(),
            'kpp' => $this->integer(),
            'account_number' => $this->integer(),
            'address' => $this->string(),
            'legal_address' => $this->string(),
            'comment' => $this->text(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%partner}}');
    }
}
