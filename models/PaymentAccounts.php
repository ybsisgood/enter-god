<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_accounts".
 *
 * @property int $id
 * @property string $name
 * @property int $payment_channel_id
 * @property int $payment_vendor_id
 * @property string|null $detail_keys
 * @property int $status
 * @property int $payment_category_id
 * @property string|null $extra_code
 * @property float $mdr_percent
 * @property float $mdr_price
 * @property float $min_payment
 * @property float $max_payment
 * @property float|null $free_mdr_min
 * @property float|null $free_mdr_max
 * @property int $sort
 * @property string|null $detail_info
 * @property string|null $how_to_payment
 * @property float|null $limit_days
 * @property float|null $limit_month
 * @property float|null $limit_year
 * @property int|null $secret_code
 */
class PaymentAccounts extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DELETED = 4;
    const STATUS_MAINTENANCE = 5;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_SORT = 'sort';

    public $sortAccounts;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_accounts';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_edc');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'payment_channel_id', 'payment_vendor_id', 'payment_category_id', 'status'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['payment_channel_id', 'payment_vendor_id', 'status', 'payment_category_id', 'sort', 'secret_code'], 'integer'],
            [['detail_keys', 'detail_info'], 'safe'],
            [['sortAccounts'], 'safe'],
            [['sortAccounts'], 'required', 'on' => self::SCENARIO_SORT],
            [['mdr_percent', 'mdr_price', 'min_payment', 'max_payment', 'free_mdr_min', 'free_mdr_max', 'limit_days', 'limit_month', 'limit_year'], 'number'],
            [['how_to_payment'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['extra_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'payment_channel_id' => 'Payment Channel',
            'payment_vendor_id' => 'Payment Vendor',
            'detail_keys' => 'Detail Keys',
            'status' => 'Status',
            'payment_category_id' => 'Payment Category',
            'extra_code' => 'Extra Code',
            'mdr_percent' => 'Mdr Percent',
            'mdr_price' => 'Mdr Price',
            'min_payment' => 'Min Payment',
            'max_payment' => 'Max Payment',
            'free_mdr_min' => 'Free Mdr Min',
            'free_mdr_max' => 'Free Mdr Max',
            'sort' => 'Sort',
            'detail_info' => 'Detail Info',
            'how_to_payment' => 'How To Payment',
            'limit_days' => 'Limit Days',
            'limit_month' => 'Limit Month',
            'limit_year' => 'Limit Year',
            'secret_code' => 'Secret Code',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PaymentAccountsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PaymentAccountsQuery(get_called_class());
    }

    public function getPaymentChannel()
    {
        return $this->hasOne(PaymentChannels::className(), ['id' => 'payment_channel_id']);
    }

    public function getPaymentVendor()
    {
        return $this->hasOne(PaymentVendor::className(), ['id' => 'payment_vendor_id']);
    }

    public function getPaymentCategory()
    {
        return $this->hasOne(PaymentCategories::className(), ['id' => 'payment_category_id']);
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_MAINTENANCE => 'Maintenance',
        ];
    }
}
