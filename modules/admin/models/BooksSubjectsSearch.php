<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BooksSubjectsSearch represents the model behind the search form of `app\modules\admin\models\BooksSubjects`.
 */
class BooksSubjectsSearch extends BooksSubjects
{
    /**
     * {@inheritdoc}
     */
    public function rules() : array{
        return [
            ['id', 'integer'],
            ['name', 'string', 'max' => 255],
            ['name', 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() : array{
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
    public function search(array $params) : ActiveDataProvider
    {
        $query = BooksSubjects::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Фильтры поиска (Выпадающие меню + точные значения)
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
