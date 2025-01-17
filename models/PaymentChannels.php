<?php

namespace app\models;

use Codeception\Scenario;
use Faker\Provider\ar_EG\Payment;
use Yii;

/**
 * This is the model class for table "payment_channels".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $payment_category_id
 * @property int $status
 * @property string|null $image_url
 * @property int $sort
 * @property string|null $detail_info
 */
class PaymentChannels extends \yii\db\ActiveRecord
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

    public $sortChannels;
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_channels';
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
            [['name', 'code', 'payment_category_id', 'status'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['payment_category_id', 'status', 'sort'], 'integer'],
            [['detail_info'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'svg', 'maxSize' => 1024 * 1024 * 0.5],
            [['sortChannels'], 'safe'],
            [['sortChannels'], 'required', 'on' => self::SCENARIO_SORT],
            [['name', 'code'], 'string', 'max' => 255],
            [['image_url'], 'default', 'value' => null, 'skipOnError' => true],            
            [['code'], 'unique'],
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
            'code' => 'Code',
            'payment_category_id' => 'Payment Category ID',
            'status' => 'Status',
            'image_url' => 'Image Url',
            'sort' => 'Sort',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PaymentChannelsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PaymentChannelsQuery(get_called_class());
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

    public function getPaymentCategory()
    {
        return $this->hasOne(PaymentCategories::className(), ['id' => 'payment_category_id']);
    }
}
