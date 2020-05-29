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
        $bitumen = $this->findProductModel(26);
        $materialCount = Product::find()->where(['is_total_amount' => 1])->sum('count');
        
        $arrBitumen = [
            'total' => [
                'procent' => $bitumen['count'] * 100 / 300 / 100,
                'count' => $bitumen['count']
            ],
            'containers' => [
                ['volume' => 100,'count' => $bitumen['count'] >= 120 ? 100 : ( $bitumen['count'] < 20 ? 0 : $bitumen['count'] - 20)],
                ['volume' => 45, 'count' => $bitumen['count'] >= 165 ? 45 : ( $bitumen['count'] < 120 ? 0 : $bitumen['count'] - 120)],
                ['volume' => 45, 'count' => $bitumen['count'] >= 210 ? 45 : ( $bitumen['count'] < 165 ? 0 : $bitumen['count'] - 165)],
                ['volume' => 45, 'count' => $bitumen['count'] >= 255 ? 45 : ( $bitumen['count'] < 210 ? 0 : $bitumen['count'] - 210)],
                ['volume' => 45, 'count' => $bitumen['count'] >= 300 ? 45 : ( $bitumen['count'] < 255 ? 0 : $bitumen['count'] - 255)],
                ['volume' => 20, 'count' => $bitumen['count'] >= 20 ? 20 : $bitumen['count']],
            ]
        ];

        $arrMaterial = [
            'count' => $materialCount,
            'percent' => $materialCount <= 0 ? 0 :$materialCount * 100 / 10000 / 100
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
