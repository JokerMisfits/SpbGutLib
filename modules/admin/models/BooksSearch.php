<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BooksSearch represents the model behind the search form of `app\modules\admin\models\Books`.
 */
class BooksSearch extends Books
{
    /**
     * {@inheritdoc}
     */
    public function rules() : array{
        return [
            [['id', 'category_id', 'subject_id', 'count', 'rest', 'stock'], 'integer'],
            [['name', 'author', 'date', 'keywords', 'ISBN', 'ISSN', 'publisher', 'publish_date', 'annotation'], 'safe'],
            [['date','publish_date'], 'match', 'pattern' => '/^[0-9]+$/i','message' => '{attribute} должна быть целым числом'],
            [['ISBN','ISSN'], 'match', 'pattern' => '/^[0-9-]+$/i','message' => '{attribute} должна состоять только из цифр и дефисов 978-5-9268-2477-0'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array{
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
    public function search(array $params) : ActiveDataProvider{
        $query = Books::find();

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
                    'stock' => SORT_DESC,
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
            'category_id' => $this->category_id,
            'subject_id' => $this->subject_id,
            'count' => $this->count,
            'rest' => $this->rest,
            'stock' => $this->stock,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'ISBN', $this->ISBN])
            ->andFilterWhere(['like', 'ISSN', $this->ISSN])
            ->andFilterWhere(['like', 'publisher', $this->publisher]);

        return $dataProvider;
    }
}
