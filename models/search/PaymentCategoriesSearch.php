<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PaymentCategories;

/**
 * PaymentCategoriesSearch represents the model behind the search form of `app\models\PaymentCategories`.
 */
class PaymentCategoriesSearch extends PaymentCategories
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'status'], 'integer'],
            [['name', 'image_url', 'detail_info'], 'safe'],
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
        $query = PaymentCategories::find();

        if ($deleted) {
            $query->where(['status' => PaymentCategories::STATUS_DELETED]);
        } else {
            $query->where(['!=', 'status', PaymentCategories::STATUS_DELETED]);
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
            'sort' => $this->sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'image_url', $this->image_url])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info]);

        return $dataProvider;
    }
}
