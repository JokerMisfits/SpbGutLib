<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AccountsSearch represents the model behind the search form of `app\modules\admin\models\Accounts`.
 */
class AccountsSearch extends Accounts
{
    /**
     * {@inheritdoc}
     */
    public function rules() : array{
        return [
            [['id', 'access_level', 'parent_id', 'pass_number', 'department_id'], 'integer'],
            ['email', 'string', 'max' => 255],
            ['username', 'string', 'max' => 32],
            [['name', 'surname', 'middle_name'], 'string', 'max' => 20],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i','message' => '{attribute} должен начинаться и содержать символы только латинского алфавита'],
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
    public function search(array $params): ActiveDataProvider
    {
        $query = Accounts::find();

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
                    'username' => SORT_ASC,
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
            'access_level' => $this->access_level,
            'department_id' => $this->department_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'pass_number', $this->pass_number]);

        return $dataProvider;
    }
}
