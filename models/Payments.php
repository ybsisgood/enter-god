<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property string|null $invoice_number
 * @property string|null $remark
 * @property int $payment_account_id
 * @property int $payment_channel_id
 * @property int $payment_vendor_id
 * @property int $payment_category_id
 * @property int|null $serial_key_id
 * @property int $outlet_id
 * @property float $subtotal
 * @property float $mdr
 * @property float $total
 * @property int $status
 * @property string $created_at
 * @property string|null $expired_at
 * @property string|null $payment_at
 * @property string|null $detail_payment
 * @property string|null $detail_info
 */
class Payments extends \yii\db\ActiveRecord
{
    const STATUS_WAITING_PAYMENT = 1;
    const STATUS_PAID = 3;
    const STATUS_REFUND = 4;
    const STATUS_EXPIRED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
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
            [['payment_account_id', 'payment_channel_id', 'payment_vendor_id', 'payment_category_id', 'outlet_id', 'subtotal', 'total'], 'required'],
            [['payment_account_id', 'payment_channel_id', 'payment_vendor_id', 'payment_category_id', 'serial_key_id', 'outlet_id', 'status'], 'integer'],
            [['subtotal', 'mdr', 'total'], 'number'],
            [['created_at', 'expired_at', 'payment_at', 'detail_payment', 'detail_info'], 'safe'],
            [['invoice_number'], 'string', 'max' => 25],
            [['remark'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_number' => 'Invoice Number',
            'remark' => 'Remark',
            'payment_account_id' => 'Payment Account ID',
            'payment_channel_id' => 'Payment Channel ID',
            'payment_vendor_id' => 'Payment Vendor ID',
            'payment_category_id' => 'Payment Category ID',
            'serial_key_id' => 'Serial Key ID',
            'outlet_id' => 'Outlet ID',
            'subtotal' => 'Subtotal',
            'mdr' => 'Mdr',
            'total' => 'Total',
            'status' => 'Status',
            'created_at' => 'Created At',
            'expired_at' => 'Expired At',
            'payment_at' => 'Payment At',
            'detail_payment' => 'Detail Payment',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PaymentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PaymentsQuery(get_called_class());
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_WAITING_PAYMENT => 'Waiting Payment',
            self::STATUS_PAID => 'Paid',
            self::STATUS_REFUND => 'Refund',
            self::STATUS_EXPIRED => 'Expired',
        ];
    }
}
