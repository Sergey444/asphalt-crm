<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
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
            [['id', 'date', 'partner_id', 'product_id', 'count', 'price', 'sum', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['bill', 'payment', 'search', 'comment'], 'safe'],
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
        $query = Order::find()->joinWith(['partner', 'product']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['date', 'partner.name', 'product.name', 'bill', 'count', 'price', 'sum', 'payment', 'status'],
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

        $query->andFilterWhere([
            'or',
            ['like', 'product.name', $this->search],
            ['like', 'partner.name', $this->search],
            ['like', 'bill', $this->search]
        ]);

        return $dataProvider;
    }
}
