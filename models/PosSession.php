<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property string $name
 * @property int $outlet_id
 * @property string $open_date
 * @property string|null $closed_date
 * @property int|null $status 0: Inactive, 1: Active, 2: Draft, 3: Completed, 4: Deleted, 5: Maintenance
 * @property int|null $slave_id
 * @property int|null $sync_slave
 */
class PosSession extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DELETED = 4;
    const STATUS_MAINTENANCE = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
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
            [['outlet_id', 'status', 'slave_id', 'sync_slave'], 'default', 'value' => null],
            [['outlet_id', 'status', 'slave_id', 'sync_slave'], 'integer'],
            [['open_date', 'closed_date'], 'safe'],
            [['name'], 'string', 'max' => 255],

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
            'outlet_id' => 'Outlet ID',
            'open_date' => 'Open Date',
            'closed_date' => 'Closed Date',
            'status' => 'Status',
            'slave_id' => 'Slave ID',
            'sync_slave' => 'Sync Slave',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\SessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SessionQuery(get_called_class());
    }

    public function getOutlet()
    {
        return $this->hasOne(PosOutlet::className(), ['id' => 'outlet_id']);
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

    public function getStatusLabel()
    {
        return self::getStatusList()[$this->status];
    }
}
