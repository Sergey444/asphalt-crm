<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m200425_150054_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'date' => $this->integer()->notNull(),
            'partner_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'bill' => $this->string(),
            'count' => $this->integer(),
            'price' => $this->integer(),
            'sum' => $this->integer(),
            'payment' => $this->string(),
            'status' => $this->boolean(),
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
        $this->dropTable('{{%order}}');
    }
}
