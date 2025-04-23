<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PosSession;

/**
 * PosSessionSearch represents the model behind the search form of `app\models\PosSession`.
 */
class PosSessionSearch extends PosSession
{

    public $outletName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'outlet_id', 'status', 'slave_id', 'sync_slave'], 'integer'],
            [['name', 'open_date', 'closed_date', 'outletName'], 'safe'],
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
        $query = PosSession::find();
        if($deleted){
            $query->andWhere(['status' => PosSession::STATUS_DELETED]);
        } else {
            $query->andWhere(['!=', 'status', PosSession::STATUS_DELETED]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id' => ['default' => SORT_DESC],
                ]
            ]
        ]);

        $dataProvider->sort->attributes['outletName'] = [
            'asc' => ['posOutlet.name' => SORT_ASC],
            'desc' => ['posOutlet.name' => SORT_DESC],
        ];

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
            'open_date' => $this->open_date,
            'closed_date' => $this->closed_date,
            'session.status' => $this->status,
            'session.slave_id' => $this->slave_id,
            'session.sync_slave' => $this->sync_slave,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'posOutlet.name', $this->outletName]);

        return $dataProvider;
    }
}
