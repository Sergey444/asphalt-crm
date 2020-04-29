<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;

use app\models\User;

/**
 * This is the model class for table "Profile".
 * use Imagine\Image\Box;
 *
 * @property int $id
 * @property int $user_id
 * @property string $surname
 * @property string $name
 * @property string $secondname
 * @property string $photo
 * @property int $date_of_birthday
 * @property int $phone
 * @property string $position
 * @property int $created_at
 * @property int $updated_at
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @var
     */
    public $img;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['phone'], 'safe'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['surname', 'name', 'position', 'secondname'], 'string', 'max' => 255],
            [['img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, HEVC, HEIF', 'maxSize' => 1024 * 1024 * 2],
            [['photo', 'address'], 'string'],
            [['date_of_birthday'], 'datetime', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'date_of_birthday'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'user_id' => 'id пользователя',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'secondname' => 'Отчество',
            'date_of_birthday' => 'Дата рождения',
            'photo' => 'Фотография',
            'phone' => 'Телефон',
            'position' => 'Должность',
            'address' => 'Адрес',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'fullName' => 'Ф.И.О пользователя'
        ];
    }

    /**
     * Сохраняем файл
     *
     * @param Object file
     * @return String path || false
     */
    public function upload($photo)
    {
        $path = 'uploads/'.date('Y-m');
        $fileName = Yii::$app->security->generateRandomString(8). '.' . $photo->extension; // $photo->baseName .
        
        $url = $path.'/'.$fileName;
        $thumbUrl = $path.'/thumb-40/'.$fileName;

        if (FileHelper::createDirectory($path)) {

                $this->deletePhoto();
                $resImage = Image::autorotate($photo->tempName);

                $metadata = $resImage->metadata();
                $metadata->offsetSet('ifd0.Orientation', 1);
                $resImage->metadata($metadata);
                Image::resize($resImage, 200, 200, false, false)->save(Yii::getAlias('@webroot/'.$url));

                $this->photo = $url;
                return true;
        }
        return false;
    }

    /**
     * Deletes photo if exists
     * @return boolean
     */
    public function deletePhoto()
    {
        return file_exists($this->photo) && unlink($this->photo);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getFullName() {
        return $this->surname . ' ' . $this->name .' '. $this->secondname;
    }

    /**
     * @return string - html
     */
    public function getHtmlStatus() {
        return $this->user->status === 10 ? '<span class="status-circle"></span>' : '<span class="status-circle status-circle--red"></span>'; 
    }
}
