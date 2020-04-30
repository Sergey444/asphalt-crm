<?php

namespace app\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $director_name
 * @property string|null $contact_name
 * @property string|null $site
 * @property string|null $inn
 * @property string|null $kpp
 * @property string|null $account_number
 * @property string|null $address
 * @property string|null $legal_address
 * @property string|null $comment
 * @property int $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner';
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
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            ['email', 'email'],
            [['name', 'phone', 'inn', 'kpp', 'account_number', 'director_name', 'contact_name', 'site', 'address', 'legal_address'], 'string', 'max' => 255],
            [['phone', 'inn', 'kpp', 'account_number', 'director_name', 'contact_name', 'site', 'address', 'legal_address', 'email', 'comment'], 'default', 'value' => null]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название компании или ИП',
            'phone' => 'Телефон',
            'email' => 'Email',
            'director_name' => 'Ф.И.О директора',
            'contact_name' => 'Контактное лицо',
            'site' => 'Веб сайт',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'account_number' => 'Расчётный счёт',
            'address' => 'Адрес',
            'legal_address' => 'Юридический адрес',
            'comment' => 'Комментарий',
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
     * @param integer $count
     * @return string
     */
    public function getTruncateComment($count)
    {
        return \yii\helpers\StringHelper::truncate($this->comment, $count, '...');
    }
}
