<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payments;
use kartik\daterange\DateRangeBehavior;

/**
 * PaymentsSearch represents the model behind the search form of `app\models\Payments`.
 */
class PaymentsSearch extends Payments
{
    public $outletName;
    public $vendorName;
    public $categoryName;
    public $channelName;
    public $deviceName;
    public $createdBy;
    public $trxIdVendor;

    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
                'dateStartFormat' => 'Y-m-d H:i:s',
                'dateEndFormat' => 'Y-m-d H:i:s',
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_account_id', 'payment_channel_id', 'payment_vendor_id', 'payment_category_id', 'serial_key_id', 'outlet_id', 'status'], 'integer'],
            [['invoice_number', 'remark', 'created_at', 'expired_at', 'payment_at', 'detail_payment', 'detail_info', 'outletName', 'vendorName', 'categoryName', 'channelName', 'deviceName', 'createdBy', 'trxIdVendor'], 'safe'],
            [['subtotal', 'mdr', 'total'], 'number'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
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
    public function search($params, $status = null, $startDate = null, $endDate = null)
    {
        $query = Payments::find();
        if($status) {
            $query->andWhere(['status' => $status]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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
            'payment_account_id' => $this->payment_account_id,
            'payment_channel_id' => $this->payment_channel_id,
            'payment_vendor_id' => $this->payment_vendor_id,
            'payment_category_id' => $this->payment_category_id,
            'serial_key_id' => $this->serial_key_id,
            'outlet_id' => $this->outlet_id,
            'subtotal' => $this->subtotal,
            'mdr' => $this->mdr,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'expired_at' => $this->expired_at,
            'payment_at' => $this->payment_at,
        ]);

        $query->andFilterWhere(['like', 'invoice_number', $this->invoice_number])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'detail_payment', $this->detail_payment])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_payment, "$.outlet"))'), mb_strtolower($this->outletName)])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_payment, "$.vendor"))'), mb_strtolower($this->vendorName)])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_payment, "$.category"))'), mb_strtolower($this->categoryName)])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_payment, "$.channel"))'), mb_strtolower($this->channelName)])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_payment, "$.device"))'), mb_strtolower($this->deviceName)])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_info, "$.changelog.created_by"))'), mb_strtolower($this->createdBy)])
            ->andFilterWhere(['like', new \yii\db\Expression('LOWER(JSON_EXTRACT(detail_payment, "$.trx_id"))'), $this->trxIdVendor])
            ->andFilterWhere(['>=', 'created_at', $this->createTimeStart])
            ->andFilterWhere(['<', 'created_at', $this->createTimeEnd]);;

        return $dataProvider;
    }
}
