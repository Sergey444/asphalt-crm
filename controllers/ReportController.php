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
                    'create-pdf-report' => ['POST']
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
        $partner_id = Yii::$app->request->get('partner') ? 'partner_id = '.Yii::$app->request->get('partner'). ' AND ' : '';
        $date_start = strtotime(Yii::$app->request->get('date_start')) ?: strtotime("-1 month");
        $date_end = strtotime(Yii::$app->request->get('date_end')) ?: strtotime('now');
        $query = $partner_id . "`date` > ".$date_start." AND `date` < ".$date_end;

        $partners = Partner::find()->limit(50)->all();

        $orders = Order::find()->where($query)->joinWith(['partner', 'product'])->all();
        $suppliers = Supplier::find()->where($query)->joinWith(['partner', 'product'])->all();

        $products = $this->getTotalProduct($orders, $suppliers);
        $nettings = $this->getNetting($orders, $suppliers);

        return $this->render('index.twig', [
            'date_start' => $date_start,
            'date_end' => $date_end,
            'partners' => $partners,
            'products' => $products,
            'nettings' => $nettings,
            'orders' => $orders,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Generates pdf document
     * @return 
     */
    public function actionCreatePdfReport()
    {
        $partner_id = Yii::$app->request->post('partner') ? 'partner_id = '.Yii::$app->request->post('partner'). ' AND ' : '';
        $date_start = strtotime(Yii::$app->request->post('date_start')) ?: strtotime("-1 month");
        $date_end = strtotime(Yii::$app->request->post('date_end')) ?: strtotime('now');
        $query = $partner_id . "`date` > ".$date_start." AND `date` < ".$date_end;

        $orders = Order::find()->where($query)->joinWith(['partner', 'product'])->all();
        $suppliers = Supplier::find()->where($query)->joinWith(['partner', 'product'])->all();
        $products = $this->getTotalProduct($orders, $suppliers);

        Yii::$app->response->format = 'pdf';

        return $this->renderPartial('print.twig', [
            'date_start' => $date_start,
            'date_end' => $date_end,
            'products' => $products,
            'orders' => $orders
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

    /**
     * @return array
     */
    private function getNetting($orders, $suppliers)
    {
        foreach ($suppliers as $supplier) {
            if ($supplier->payment == 'Взаимозачёт') {
                $newArray[$supplier->partner->name][$supplier->product->name]['countBuy'] += $supplier->count;
                $newArray[$supplier->partner->name][$supplier->product->name]['priceBuy'] += $supplier->sum;
                $newArray[$supplier->partner->name][$supplier->product->name]['result'] += $supplier->sum;
            }
        }

        foreach($orders as $order) {
            if ($order->payment == 'Взаимозачёт') {
                $newArray[$order->partner->name][$order->product->name]['countSale'] += $order->count;
                $newArray[$order->partner->name][$order->product->name]['priceSale'] += $order->sum;
                $newArray[$order->partner->name][$order->product->name]['result'] -= $order->sum;
            }
        }

        return $newArray;
    }

}
