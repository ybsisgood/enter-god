<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PaymentVendor;

/**
 * PaymentVendorSearch represents the model behind the search form of `app\models\PaymentVendor`.
 */
class PaymentVendorSearch extends PaymentVendor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'code', 'detail_info'], 'safe'],
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
        $query = PaymentVendor::find();

        if ($deleted) {
            $query->where(['=', 'status', PaymentVendor::STATUS_DELETED]);
        } else {
            $query->where(['!=', 'status', PaymentVendor::STATUS_DELETED]);
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
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info]);

        return $dataProvider;
    }
}
