<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_wallet_vendor".
 *
 * @property int $id
 * @property int $payment_vendor_id
 * @property int $type 1:plus 2:minus
 * @property string|null $note_wallet
 * @property float $amount
 * @property float $wallet_before
 * @property float $wallet_after
 * @property string $created_date
 */
class LogWalletVendor extends \yii\db\ActiveRecord
{
    const TYPE_PLUS = 1;
    const TYPE_MINUS = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_wallet_vendor';
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
            [['payment_vendor_id', 'type'], 'required'],
            [['payment_vendor_id', 'type'], 'integer'],
            [['note_wallet'], 'string'],
            [['amount', 'wallet_before', 'wallet_after'], 'number'],
            [['created_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_vendor_id' => 'Payment Vendor ID',
            'type' => 'Type',
            'note_wallet' => 'Note Wallet',
            'amount' => 'Amount',
            'wallet_before' => 'Wallet Before',
            'wallet_after' => 'Wallet After',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\LogWalletVendorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\LogWalletVendorQuery(get_called_class());
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_PLUS => 'Plus',
            self::TYPE_MINUS => 'Minus',
        ];
    }
}
