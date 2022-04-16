<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\people;

/**
 * PeopleSearch represents the model behind the search form of `app\modules\admin\models\people`.
 */
class PeopleSearch extends people
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'access_level', 'pass_number', 'department_id'], 'integer'],
            [['name', 'surname', 'middle_name', 'comment', 'books'], 'safe'],
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
        $query = people::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'access_level' => $this->access_level,
            'child_id' => $this->child_id,
            'pass_number' => $this->pass_number,
            'department_id' => $this->department_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'books', $this->books]);

        return $dataProvider;
    }
}
