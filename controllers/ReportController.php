<?php

namespace app\controllers;

use Yii;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Partner;
use app\models\Order;
use app\models\Supplier;

class ReportController extends \yii\web\Controller
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
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $partner_id = Yii::$app->request->post('partner') ? 'partner_id = '.Yii::$app->request->post('partner'). ' AND ' : '';
        $date_start = strtotime(Yii::$app->request->post('date_start')) ?: strtotime("-1 month");
        $date_end = strtotime(Yii::$app->request->post('date_end')) ?: strtotime('now');
        $query = $partner_id . "`date` > ".$date_start." AND `date` < ".$date_end;

        $partners = Partner::find()->limit(50)->all();

        $orders = Order::find()->where($query)->joinWith(['partner', 'product'])->all();
        $suppliers = Supplier::find()->where($query)->joinWith(['partner', 'product'])->all();

        $products = $this->getTotalProduct($orders, $suppliers);

        return $this->render('index.twig', [
            'date_start' => $date_start,
            'date_end' => $date_end,
            'partners' => $partners,
            'products' => $products,
            'orders' => $orders,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * @return array
     */
    private function getTotalProduct($orders, $suppliers)
    {
        foreach($orders as $order) {
            $newArray[$order->product->name]['countSale'] += $order->count;
            $newArray[$order->product->name]['priceSale'] += $order->sum;
        }

        foreach ($suppliers as $supplier) {
            $newArray[$supplier->product->name]['countBuy'] += $supplier->count;
            $newArray[$supplier->product->name]['priceBuy'] += $supplier->sum;
        }

        return $newArray;
    }

}
