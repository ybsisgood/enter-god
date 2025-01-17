<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PaymentChannels;

/**
 * PaymentChannelsSearch represents the model behind the search form of `app\models\PaymentChannels`.
 */
class PaymentChannelsSearch extends PaymentChannels
{
    public $categoryName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_category_id', 'status', 'sort'], 'integer'],
            [['name', 'code', 'image_url', 'detail_info', 'categoryName'], 'safe'],
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
        $query = PaymentChannels::find();

        if ($deleted) {
            $query->andWhere(['status' => PaymentChannels::STATUS_DELETED]);
        } else {
            $query->andWhere(['!=', 'status', PaymentChannels::STATUS_DELETED]);
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
            'payment_category_id' => $this->payment_category_id,
            'status' => $this->status,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'image_url', $this->image_url])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_info, "$.category.name"))'), $this->categoryName]);

        return $dataProvider;
    }
}
