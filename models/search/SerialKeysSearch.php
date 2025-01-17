<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SerialKeys;

/**
 * SerialKeysSearch represents the model behind the search form of `app\models\SerialKeys`.
 */
class SerialKeysSearch extends SerialKeys
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'outlet_id', 'status'], 'integer'],
            [['name', 'activation_code', 'local_code', 'detail_info'], 'safe'],
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
    public function search($params, $deleted = false)
    {
        $query = SerialKeys::find();

        if ($deleted) {
            $query->where(['status' => SerialKeys::STATUS_DELETED]);
        } else {
            $query->where(['!=', 'status', SerialKeys::STATUS_DELETED]);
        }

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
            'outlet_id' => $this->outlet_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'activation_code', $this->activation_code])
            ->andFilterWhere(['like', 'local_code', $this->local_code])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info]);

        return $dataProvider;
    }
}
