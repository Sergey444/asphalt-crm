<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
     * Index action
     */
    public function actionIndex()
    {

        $form_class = 'needs-validation ';
        if (Yii::$app->request->isAjax) {
            // $form_class = 'needs-validation was-validated';

            if (Yii::$app->request->post('company-name') !== Yii::$app->name) {
                $this->setName(Yii::$app->request->post('company-name'));
            }

            if (Yii::$app->request->post('admin-email') !== Yii::$app->params->adminEmail) {
                $this->setAdminEmail(Yii::$app->request->post('admin-email'));
            }

            if (Yii::$app->request->post('sender-email') !== Yii::$app->params->senderEmail) {
                $this->setSenderEmail(Yii::$app->request->post('sender-email'));
            }

            return $this->redirect(['index']);
        }

        // print_r(Yii::getAlias('@web').'/favicon.ico');

        return $this->render('index.twig', [
            'file_exists' => file_exists('/favicon.ico'),
            'form_class' => $form_class
        ]);
    }

    /**
     * @param string $name
     * @return boolean
     */
    private function setName($name)
    {
        return file_put_contents(__DIR__ .'/../config/app/app.name.php', htmlspecialchars($name));
    }

    /**
     * @param string $email
     * @return boolean
     */
    private function setAdminEmail($email)
    {
        return file_put_contents(__DIR__ .'/../config/app/app.admin.email.php', htmlspecialchars($email));
    }

    /**
     * @param string $email
     * @return boolean
     */
    private function setSenderEmail($email)
    {
        return file_put_contents(__DIR__ .'/../config/app/app.sender.email.php', htmlspecialchars($email));
    }

}
