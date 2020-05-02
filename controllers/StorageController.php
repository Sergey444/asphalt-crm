<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class StorageController extends \yii\web\Controller
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

        return $this->render('index.twig');
    }

}
