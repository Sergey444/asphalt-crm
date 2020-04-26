<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $date
 * @property int $partner_id
 * @property int $product_id
 * @property string|null $bill
 * @property int|null $count
 * @property int|null $price
 * @property int|null $sum
 * @property string|null $payment
 * @property int|null $status
 * @property string|null $comment
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
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
            [['date'], 'safe'],
            [['date'], 'datetime', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'date'],
            [['date','partner_id', 'product_id'], 'required'],
            [['partner_id', 'product_id', 'count', 'price', 'sum', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['bill', 'payment'], 'string', 'max' => 255],
            [['payment', 'comment', 'bill'], 'default', 'value' => null]
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
            'status' => 'Status',
            'comment' => 'Comment',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner() 
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() 
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * Returns partners from Partner model for list to form select
     * has limit 50 elements
     * @return array
     */
    public function getPartners() 
    {
        $model = Partner::find()->limit(50)->all();
        return ArrayHelper::map($model, 'id', 'name');
    }

    /**
     * Returns products from Product model for list to form select
     * has limit 50 elements
     * @return array
     */
    public function getProducts() 
    {
        $model = Product::find()->limit(50)->all();
        return ArrayHelper::map($model, 'id', 'name');
    }

    /**
     * Returns an HTML switch for status
     * @return string
     */
    public function getHtmlStatus()
    {
        $status = $this->status ? 'checked' : '';
        return '<label class="switch">
                    <input class="switch__input" data-id="' .$this->id. '" data-name="status" type="checkbox" ' .$status. '>
                    <span class="switch__slider round"></span>
                </label>';
    }
}