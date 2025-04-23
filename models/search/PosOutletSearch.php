<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PosOutlet;

/**
 * PosOutletSearch represents the model behind the search form of `app\models\PosOutlet`.
 */
class PosOutletSearch extends PosOutlet
{
    public $location_lat;
    public $location_lng;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'slave_id', 'sync_slave', 'status'], 'integer'],
            [['name', 'code', 'slug_url', 'address', 'location', 'hwid_server', 'secret_key', 'ip_whitelist', 'detail_info', 'location_lat', 'location_lng'], 'safe'],
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
        $query = PosOutlet::find();

        if($deleted){
            $query->andWhere(['status' => PosOutlet::STATUS_DELETED]);
        } else {
            $query->andWhere(['!=', 'status', PosOutlet::STATUS_DELETED]);
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
            'slave_id' => $this->slave_id,
            'sync_slave' => $this->sync_slave,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'code', $this->code])
            ->andFilterWhere(['ilike', 'slug_url', $this->slug_url])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'location', $this->location])
            ->andFilterWhere(['ilike', 'hwid_server', $this->hwid_server])
            ->andFilterWhere(['ilike', 'secret_key', $this->secret_key])
            ->andFilterWhere(['ilike', 'ip_whitelist', $this->ip_whitelist])
            ->andFilterWhere(['ilike', 'detail_info', $this->detail_info])
            ->andFilterWhere(['ilike', new \yii\db\Expression('jsonb_extract_path_text(location::jsonb, \'lat\')'), $this->location_lat])
            ->andFilterWhere(['ilike', new \yii\db\Expression('jsonb_extract_path_text(location::jsonb, \'lng\')'), $this->location_lng]);
        return $dataProvider;
    }
}
