<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PaymentAccounts;

/**
 * PaymentAccountsSearch represents the model behind the search form of `app\models\PaymentAccounts`.
 */
class PaymentAccountsSearch extends PaymentAccounts
{
    public $nameVendor;
    public $nameCategory;
    public $nameChannel;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_channel_id', 'payment_vendor_id', 'status', 'payment_category_id', 'sort', 'secret_code'], 'integer'],
            [['name', 'detail_keys', 'extra_code', 'detail_info', 'how_to_payment', 'nameVendor', 'nameCategory', 'nameChannel'], 'safe'],
            [['mdr_percent', 'mdr_price', 'min_payment', 'max_payment', 'free_mdr_min', 'free_mdr_max', 'limit_days', 'limit_month', 'limit_year'], 'number'],
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
        $query = PaymentAccounts::find();
        if($deleted) {
            $query->andWhere(['status' => PaymentAccounts::STATUS_DELETED]);
        } else {
            $query->andWhere(['!=', 'status', PaymentAccounts::STATUS_DELETED]);
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
            'payment_channel_id' => $this->payment_channel_id,
            'payment_vendor_id' => $this->payment_vendor_id,
            'status' => $this->status,
            'payment_category_id' => $this->payment_category_id,
            'mdr_percent' => $this->mdr_percent,
            'mdr_price' => $this->mdr_price,
            'min_payment' => $this->min_payment,
            'max_payment' => $this->max_payment,
            'free_mdr_min' => $this->free_mdr_min,
            'free_mdr_max' => $this->free_mdr_max,
            'sort' => $this->sort,
            'limit_days' => $this->limit_days,
            'limit_month' => $this->limit_month,
            'limit_year' => $this->limit_year,
            'secret_code' => $this->secret_code,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'detail_keys', $this->detail_keys])
            ->andFilterWhere(['like', 'extra_code', $this->extra_code])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info])
            ->andFilterWhere(['like', 'how_to_payment', $this->how_to_payment])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_info, "$.vendor.name"))'), $this->nameVendor])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_info, "$.category.name"))'), $this->nameCategory])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_info, "$.channel.name"))'), $this->nameChannel]);

        return $dataProvider;
    }
}
