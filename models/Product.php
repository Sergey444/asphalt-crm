<?php

namespace app\models;

use Yii;

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
            'name' => 'Название',
            'price' => 'Цена',
            'count' => 'Количество',
            'total' => 'Сумма',
            'unit' => 'Единица измерения',
            'description' => 'Описание',
            'truncateDescription' => 'Описание',
            'created_by' => 'Кем создан',
            'updated_by' => 'Кем изменён',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->session->setFlash('success', 'Запись успешно сохранена');
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
       return $this->hasMany(Recipe::className(), ['product_id' => 'id']);
    }

    
    /**
     * @return string
     */
    public function getRecipesList()
    {
        if (!$this->recipes) {
            return '<span class="not-set">(не задано)</span>';
        }
        foreach($this->recipes as $key => $recipe) {
            $html .= '<div><span>'.($key + 1).'</span> <span>'.$recipe->product->name.'</span></div>';
        }

        return $html;
       
    }
}
