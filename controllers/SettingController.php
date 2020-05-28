<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Setting;

use Yii;

class SettingController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * Displays main settings
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            if (Yii::$app->request->post('company-name') !== Yii::$app->name) {
                $this->setDataToFile(Yii::$app->request->post('company-name'), 'app.name.php');}
            if (Yii::$app->request->post('admin-email') !== Yii::$app->params->adminEmail) {
                $this->setDataToFile(Yii::$app->request->post('admin-email'), 'app.admin.email.php');}
            if (Yii::$app->request->post('sender-email') !== Yii::$app->params->senderEmail) {
                $this->setDataToFile(Yii::$app->request->post('sender-email'), 'app.sender.email.php');}
            if (Yii::$app->request->post('sender-password') !== Yii::$app->params->mail->password) {
                $this->setDataToFile(Yii::$app->request->post('sender-password'), 'app.sender.email.password.php');}
            if (Yii::$app->request->post('host') !== Yii::$app->params->mail->password) {
                $this->setDataToFile(Yii::$app->request->post('host'), 'app.sender.host.php');}
            if (Yii::$app->request->post('encryption') !== Yii::$app->params->mail->password) {
                $this->setDataToFile(Yii::$app->request->post('encryption'), 'app.sender.encryption.php');}
            if (Yii::$app->request->post('port') !== Yii::$app->params->mail->password) {
                $this->setDataToFile(Yii::$app->request->post('port'), 'app.sender.port.php');}

            return $this->redirect(['index']);
        }

        return $this->render('index.twig');
    }

    /**
     * Displays storage settings
     */
    public function actionStorage()
    {
        $settings = Setting::find()->asArray()->all();

        return $this->render('storage.twig');
    }

    /**
     * @param string $name
     * @param string $file
     * @return boolean
     */
    private function setDataToFile($name, $file)
    {
        return file_put_contents(__DIR__ .'/../config/app/'.$file, htmlspecialchars($name));
    }

}
