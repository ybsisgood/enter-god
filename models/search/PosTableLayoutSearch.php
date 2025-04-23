<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PosTableLayout;

/**
 * PosTableLayoutSearch represents the model behind the search form of `app\models\PosTableLayout`.
 */
class PosTableLayoutSearch extends PosTableLayout
{
    public $outletName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'outlet_id', 'layout', 'status'], 'integer'],
            [['name', 'positioning', 'detail_info', 'outletName'], 'safe'],
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
    public function search($params, $deleted = false, $outletID = null)
    {
        $query = PosTableLayout::find()->joinWith('outlet');
        if($outletID) {
            $query->andWhere(['outlet.id' => $outletID]);
        }
        if($deleted) {
            $query->andWhere(['table_layout.status' => PosTableLayout::STATUS_DELETED]);
        } else {
            $query->andWhere(['!=', 'table_layout.status', PosTableLayout::STATUS_DELETED]);
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
            'layout' => $this->layout,
            'table_layout.status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'positioning', $this->positioning])
            ->andFilterWhere(['ilike', 'detail_info', $this->detail_info])
            ->andFilterWhere(['ilike', 'outlet.name', $this->outletName]);

        return $dataProvider;
    }
}
