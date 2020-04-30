<?php

namespace app\controllers;

class StorageController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index.twig');
    }

}
