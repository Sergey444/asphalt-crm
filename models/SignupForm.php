<?php
namespace app\models;

use Yii;
use yii\base\Model;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $status;

    public $surname;
    public $name;
    public $secondname;
    public $date_of_birthday;
    public $phone;
    public $user_id;
    public $position;

    public $user;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            [['password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],

            ['status', 'integer'],
            ['name', 'required'],

            ['phone', 'safe'],
            [['user_id'], 'integer'],
            [['surname', 'name', 'secondname', 'position'], 'string', 'max' => 255],
            [['date_of_birthday'], 'datetime', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'date_of_birthday'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'secondname' => 'Отчество',
            'position' => 'Должность',
            'date_of_birthday' => 'Дата рождения',
            'phone' => 'Телефон',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля'
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        if ($this->saveUserData() && $this->id = $this->savePersonalData()) {
            if (!$this->sendEmail()) {
                Yii::$app->session->setFlash('error', 'Не удалось отправить сообщение, проверьте настройки почтовых сервисов.');
            }
            return true;
        }
        return false;

    }

    /**
     * Saves user data from model and call function sends email
     * If user does't exist then will set status 10
     * @return false|integer userId
     */
    private function saveUserData()
    {
        $user = new User();
        $user->username = $this->email;
        $user->email = $this->email;
        $user->status = User::find()->exists() ? 9 : 10;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $this->user = $user;

        $auth = Yii::$app->authManager;
        $authorRole = User::find()->exists() ? $auth->getRole('author') : $auth->getRole('admin');
        $result = $user->save();

        $auth->assign($authorRole, $this->user->getId());
        
        return $result;
    }

    /**
     * Sets personal 
     * @return false|integer
     */
    private function savePersonalData()
    {
        $personal = new Profile();
        $personal->name = $this->name ? $this->name : null;
        $personal->surname = $this->surname ? $this->surname : null;
        $personal->secondname = $this->secondname ? $this->secondname : null;
        $personal->date_of_birthday = $this->date_of_birthday ? strtotime($this->date_of_birthday) : null;
        $personal->phone = $this->phone ? $this->phone : null;
        $personal->user_id = $this->user->getId();
        $personal->position = $this->position;
        $personal->save();

        return $personal->getPrimaryKey();
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        return Yii::$app->user->login($this->user, 0);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail()
    {
        if (Yii::$app->params['senderEmail']) {
            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                    ['user' => $this->user]
                )
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
                ->setTo($this->email)
                ->setSubject('Email зарегистрирован в приложении клуба' )
                ->send();
        }
        return false;
    }
}
