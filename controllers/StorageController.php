<?php

namespace app\controllers;
use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

use app\models\Product;

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
        $bitumen = $this->findProductModel(2);
        $materialCount = Product::find()->where(['>', 'id', '0'])->sum('count');
        
        $arrBitumen = [
            'total' => [
                'procent' => $bitumen['count'] * 100 / 300 / 100,
                'count' => $bitumen['count']
            ],
            'containers' => [
                ['volume' => 100,'count' => $bitumen['count'] >= 100 ? 100 : $bitumen['count']],
                ['volume' => 45, 'count' => $bitumen['count'] >= 145 ? 100 : ( $bitumen['count'] < 100 ? 0 : $bitumen['count'] - 100)],
                ['volume' => 45, 'count' => $bitumen['count'] >= 190 ? 100 : ( $bitumen['count'] < 145 ? 0 : $bitumen['count'] - 145)],
                ['volume' => 45, 'count' => $bitumen['count'] >= 235 ? 100 : ( $bitumen['count'] < 190 ? 0 : $bitumen['count'] - 190)],
                ['volume' => 45, 'count' => $bitumen['count'] >= 280 ? 100 : ( $bitumen['count'] < 235 ? 0 : $bitumen['count'] - 235)],
                ['volume' => 20, 'count' => $bitumen['count'] == 300 ? 100 : ( $bitumen['count'] < 280 ? 0 : $bitumen['count'] - 280)],
            ]
        ];

        $arrMaterial = [
            'count' => $materialCount,
            'percent' => $materialCount * 100 / 10000 / 100
        ];

        return $this->render('index.twig', [
            'bitumen' => $arrBitumen,
            'material' => $arrMaterial
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProductModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
