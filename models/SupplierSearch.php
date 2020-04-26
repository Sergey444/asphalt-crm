<?php

namespace app\models;

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
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'or',
            ['like', 'product_id', $this->search],
            ['like', 'partner_id', $this->search],
            ['like', 'comment', $this->search],
            ['like', 'bill', $this->search]
        ]);

        return $dataProvider;
    }
}
