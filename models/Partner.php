<?php

namespace app\models;

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
            [['name', 'phone', 'inn', 'kpp', 'account_number', 'email', 'director_name', 'contact_name', 'site', 'address', 'legal_address'], 'string', 'max' => 255],
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
            'phone' => 'Phone',
            'email' => 'Email',
            'director_name' => 'Director Name',
            'contact_name' => 'Contact Name',
            'site' => 'Site',
            'inn' => 'Inn',
            'kpp' => 'Kpp',
            'account_number' => 'Account Number',
            'address' => 'Address',
            'legal_address' => 'Legal Address',
            'comment' => 'Comment',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
