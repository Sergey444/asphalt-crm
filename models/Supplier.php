<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use yii\helpers\ArrayHelper;

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
            [['date'], 'safe'],
            [['date', 'partner_id', 'product_id'], 'required'],
            [['date'], 'datetime', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'date'],
            [['partner_id', 'product_id', 'bill', 'count', 'price', 'sum', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['payment'], 'string', 'max' => 255],
            [['payment'], 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'partner_id' => 'Партнёр',
            'product_id' => 'Товар',
            'bill' => 'Номер счёта',
            'count' => 'Количество',
            'price' => 'Цена',
            'sum' => 'Сумма',
            'payment' => 'Тип оплаты',
            'comment' => 'Комментарий',
            'created_by' => 'Кем создан',
            'updated_by' => 'Кем изменён',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
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
     * Get partners from Partner model for list to form select
     * has limit 50 elements
     * @return array
     */
    public function getPartners() 
    {
        $model = Partner::find()->limit(50)->all();
        return ArrayHelper::map($model, 'id', 'name');
    }

    /**
     * Get products from Product model for list to form select
     * has limit 50 elements
     * @return array
     */
    public function getProducts() 
    {
        $model = Product::find()->limit(50)->all();
        return ArrayHelper::map($model, 'id', 'name');
    }
}
