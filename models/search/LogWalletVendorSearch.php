<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogWalletVendor;

/**
 * LogWalletVendorSearch represents the model behind the search form of `app\models\LogWalletVendor`.
 */
class LogWalletVendorSearch extends LogWalletVendor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_vendor_id', 'type'], 'integer'],
            [['note_wallet', 'created_date'], 'safe'],
            [['amount', 'wallet_before', 'wallet_after'], 'number'],
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
    public function search($params, $id = null)
    {
        $query = LogWalletVendor::find();

        if ($id) {
            $query->where(['payment_vendor_id' => $id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
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
            'payment_vendor_id' => $this->payment_vendor_id,
            'type' => $this->type,
            'amount' => $this->amount,
            'wallet_before' => $this->wallet_before,
            'wallet_after' => $this->wallet_after,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'note_wallet', $this->note_wallet]);

        return $dataProvider;
    }
}
