<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "outlets".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string|null $detail_info
 */
class Outlets extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DELETED = 4;
    const STATUS_MAINTENANCE = 5;
    
    public $address;
    public $sortCategory;
    public $sortChannel;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outlets';
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
            [['name', 'status', 'address'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['status'], 'integer'],
            [['detail_info', 'sortCategory', 'sortChannel'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 1000],
            [['address'], 'default', 'value' => null, 'skipOnError' => true],
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
            'status' => 'Status',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\OutletsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\OutletsQuery(get_called_class());
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
