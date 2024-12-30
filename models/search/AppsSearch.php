<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Apps;

/**
 * AppsSearch represents the model behind the search form of `app\models\Apps`.
 */
class AppsSearch extends Apps
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'status_env'], 'integer'],
            [['name', 'description', 'code_app', 'pic', 'live_date', 'detail_info'], 'safe'],
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
     * @param bool $deleted
     *
     * @return ActiveDataProvider
     */
    public function search($params, $deleted = false)
    {
        if ($deleted) {
            $query = Apps::find()->where(['status' => Apps::STATUS_DELETED]);
        } else {
            $query = Apps::find()->where(['!=', 'status', Apps::STATUS_DELETED]);
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
            'status_env' => $this->status_env,
            'live_date' => $this->live_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'code_app', $this->code_app])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info]);

        return $dataProvider;
    }
}
