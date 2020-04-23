<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Profile;

/**
 * ProfileSearch represents the model behind the search form of `app\models\Profile`.
 */
class ProfileSearch extends Profile
{

    public function attributes()
    {
        return array_merge( parent::attributes(), ['username'] );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'date_of_birthday', 'position', 'phone', 'created_at', 'updated_at'], 'integer'],
            [['surname', 'name', 'secondname', 'username'], 'safe'],
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
        $query = Profile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>  ['attributes' => ['username', 'fullName', 'user.username', 'position', 'name', 'secondname', 'surname', 'date_of_birthday', 'user_id','id','phone','created_at','updated_at']]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->joinWith( ['user'] );

        $query->andFilterWhere([
            'or',
            ['like', 'surname', $this->name],
            ['like', 'name', $this->name],
            ['like', 'phone', $this->name]
        ]);

        return $dataProvider;
    }
}
