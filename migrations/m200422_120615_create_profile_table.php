<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile}}`.
 */
class m200422_120615_create_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'user_id' =>  $this->integer(),
            'surname' => $this->string(),
            'name' => $this->string(),
            'secondname' => $this->string(),
            'date_of_birthday' => $this->integer(),
            'phone' => $this->string(),
            'address' => $this->string(),
            'position' => $this->string(),
            'photo' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profile}}');
    }
}
