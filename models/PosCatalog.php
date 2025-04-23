<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "catalog".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $slug_url
 * @property int|null $status
 * @property string|null $detail_info
 */
class PosCatalog extends \yii\db\ActiveRecord
{
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
        return 'catalog';
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
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['detail_info'], 'safe'],
            [['name', 'slug_url'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PosCatalogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PosCatalogQuery(get_called_class());
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
