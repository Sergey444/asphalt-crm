<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Partner;

/**
 * PartnerSearch represents the model behind the search form of `app\models\Partner`.
 */
class PartnerSearch extends Partner
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
            [['id',  'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'phone', 'email', 'inn', 'kpp', 'account_number', 'director_name', 'contact_name', 'site', 'address', 'legal_address', 'comment', 'search'], 'safe'],
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
        $query = Partner::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'or',
            ['like', 'name', $this->search],
            ['like', 'phone', $this->search],
            ['like', 'email', $this->search],
            ['like', 'director_name', $this->search],
            ['like', 'contact_name', $this->search],
            ['like', 'site', $this->search],
            ['like', 'address', $this->search],
            ['like', 'legal_address', $this->search],
            ['like', 'inn', $this->search],
            ['like', 'kpp', $this->search],
            ['like', 'account_number', $this->search]
        ]);

        return $dataProvider;
    }
}
