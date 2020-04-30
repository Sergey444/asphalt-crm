<?php

namespace app\models;

use Yii;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Supplier;

/**
 * SupplierSearch represents the model behind the search form of `app\models\Supplier`.
 */
class SupplierSearch extends Supplier
{

    /**
     * @var string
     */
    public $search;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'partner_id', 'bill', 'count', 'price', 'sum', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['product_id', 'payment', 'comment', 'search'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Supplier::find()->joinWith(['product', 'partner']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['date', 'partner.name', 'product.name', 'bill', 'count', 'price', 'sum', 'payment'],
                'defaultOrder' => [
                    'date' => SORT_DESC
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere($this->getFilterByTime());

        $query->andFilterWhere([
            'or',
            ['like', 'product.name', $this->search],
            ['like', 'partner.name', $this->search],
            ['like', 'bill', $this->search]
        ]);

        return $dataProvider;
    }

    /**
     * @return array
     */
    private function getFilterByTime()
    {
        $value = Yii::$app->request->cookies->get('current-sup-list')->value;
        if ($post = Yii::$app->request->post('current')) {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'current-sup-list',
                'value' => $post,
            ]));
            $value = $post;
        }

        switch ($value) {
            case 'year': 
                return ['>', 'date', strtotime(date('Y-01-01'))];
            case 'month':
                return ['>', 'date', strtotime(date('Y-m-01'))];
            default: 
                return ['>', 'date', strtotime(0)];
        }
    }
}
