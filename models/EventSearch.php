<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EventSearch represents the model behind the search form about `app\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id', 'created_at', 'updated_at', 'joined_users_counter',
                    'awareness_created_counter'
                ],
                'integer'
            ],
            [['name', 'hashtag', 'description', 'occurred_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params attributes to be searched
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Event::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->orderBy('occurred_on DESC');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'occurred_on' => $this->occurred_on,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'joined_users_counter' => $this->joined_users_counter,
            'awareness_created_counter' => $this->awareness_created_counter,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'hashtag', $this->hashtag])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
