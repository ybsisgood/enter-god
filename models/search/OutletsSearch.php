<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Outlets;

/**
 * OutletsSearch represents the model behind the search form of `app\models\Outlets`.
 */
class OutletsSearch extends Outlets
{
    public $address;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'detail_info', 'address'], 'safe'],
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
        $query = Outlets::find();

        if ($deleted) {
            $query->where(['status' => Outlets::STATUS_DELETED]);
        } else {
            $query->where(['!=', 'status', Outlets::STATUS_DELETED]);
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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info])
            ->andFilterWhere(['like', new \yii\db\Expression("LOWER(JSON_EXTRACT(detail_info, '$.address'))"), $this->address]);

        return $dataProvider;
    }
}
