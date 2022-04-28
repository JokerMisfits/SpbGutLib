<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BooksHistorySearch represents the model behind the search form of `app\modules\admin\models\BooksHistory`.
 */
class BooksHistorySearch extends BooksHistory
{
    /**
     * {@inheritdoc}
     */
    public function rules() : array{
        return [
            [['id', 'book_id', 'user_id', 'active'], 'integer'],
            ['count', 'integer', 'min' => 0],
            ['count', 'integer', 'max' => 999],
            ['comment', 'string', 'max' => 255],
            [['date_from', 'date_end'], 'string', 'max' => 30],
            ['comment', 'trim'],
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
        $query = BooksHistory::find();

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
                    'date_from' => SORT_DESC,
                    'active' => SORT_DESC,
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
            'book_id' => $this->book_id,
            'active' => $this->active,
            'count' => $this->count,
        ]);

        $query->andFilterWhere(['like', 'date_from', $this->date_from])
            ->andFilterWhere(['like', 'date_end', $this->date_end])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
