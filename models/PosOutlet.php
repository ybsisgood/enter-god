<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "outlet".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $slug_url
 * @property string|null $address
 * @property string|null $location
 * @property string|null $hwid_server
 * @property string|null $secret_key
 * @property string|null $ip_whitelist
 * @property int|null $slave_id
 * @property int|null $sync_slave
 * @property int $status 0: Inactive, 1: Active, 2: Draft, 3: Completed, 4: Deleted, 5: Maintenance
 * @property string $detail_info
 */
class PosOutlet extends \yii\db\ActiveRecord
{
    public $location_lat;
    public $location_lng;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DELETED = 4;
    const STATUS_MAINTENANCE = 5;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outlet';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pos');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'status'], 'required', 'on' => self::SCENARIO_CREATE],
            [['name', 'code', 'status'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['address', 'location_lat', 'location_lng'], 'string'],
            [['location', 'detail_info'], 'safe'],
            [['slave_id', 'sync_slave'], 'default', 'value' => null],
            [['slave_id', 'sync_slave', 'status'], 'integer'],
            [['name', 'slug_url', 'hwid_server', 'secret_key', 'ip_whitelist'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 10],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE, self::STATUS_DELETED]],
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
            'slug_url' => 'Slug Url',
            'address' => 'Address',
            'location' => 'Location',
            'hwid_server' => 'Hwid Server',
            'secret_key' => 'Secret Key',
            'ip_whitelist' => 'Ip Whitelist',
            'slave_id' => 'Slave ID',
            'sync_slave' => 'Sync Slave',
            'status' => 'Status',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PosOutletQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PosOutletQuery(get_called_class());
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active',
            // self::STATUS_DRAFT => 'Banned',
            // self::STATUS_COMPLETED => 'Completed',
            // self::STATUS_DELETED => 'Deleted',
            // self::STATUS_MAINTENANCE => 'Maintenance',
        ];
    }

    public static function getStatusLabel()
    {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DRAFT => 'Banned',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_MAINTENANCE => 'Maintenance',

        ];
    }
}
