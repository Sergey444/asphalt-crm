<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property int|null $price
 * @property float|null $count
 * @property string|null $unit
 * @property string|null $description
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['price', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['count'], 'number'],
            [['description'], 'string'],
            [['name', 'unit'], 'string', 'max' => 255],
            [['count', 'unit', 'description'], 'default', 'value' => null]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'count' => 'Count',
            'unit' => 'Unit',
            'description' => 'Description',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

     /**
      * Returns sum price and count values
      * @return integer
      */
    public function getTotal()
    {
        return $this->price * $this->count;
    }

    /**
     * @param integer
     * @return string
     */
    public function getTruncateDescription()
    {
        return \yii\helpers\StringHelper::truncate($this->description, 50, '...');
    }
}
