<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier}}`.
 */
class m200424_094033_create_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey(),
            'date' => $this->integer()->notNull(),
            'partner_id' => $this->integer()->notNull(),
            'product_id' => $this->string()->notNull(),
            'bill' => $this->string(),
            'count' => $this->integer(),
            'price' => $this->integer(),
            'sum' => $this->integer(),
            'payment' => $this->string(),
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
        $this->dropTable('{{%supplier}}');
    }
}
