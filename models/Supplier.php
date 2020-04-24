<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property int $date
 * @property int $partner_id
 * @property string $product_id
 * @property int|null $bill
 * @property int|null $count
 * @property int|null $price
 * @property int|null $sum
 * @property string|null $payment
 * @property string|null $comment
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
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
            [['date', 'partner_id', 'product_id'], 'required'],
            [['date', 'partner_id', 'bill', 'count', 'price', 'sum', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['product_id', 'payment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'partner_id' => 'Partner ID',
            'product_id' => 'Product ID',
            'bill' => 'Bill',
            'count' => 'Count',
            'price' => 'Price',
            'sum' => 'Sum',
            'payment' => 'Payment',
            'comment' => 'Comment',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
