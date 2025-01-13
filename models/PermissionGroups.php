<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permission groups".
 *
 * @property int $id
 * @property int $app_id
 * @property string $name
 * @property string|null $code_permission_groups
 * @property int $status
 * @property string|null $detail_info
 */
class PermissionGroups extends \yii\db\ActiveRecord
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
        return 'permission_groups';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sso');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'name', 'status', 'code_permission_groups'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['app_id', 'status'], 'integer'],
            [['detail_info'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code_permission_groups'], 'string', 'max' => 50],
            [['code_permission_groups'], 'match', 'pattern' => '/^[a-zA-Z]+$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'name' => 'Name',
            'code_permission_groups' => 'Code Permission Groups',
            'status' => 'Status',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PermissionGroupsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PermissionGroupsQuery(get_called_class());
    }

    public function getApps()
    {
        return $this->hasOne(Apps::className(), ['id' => 'app_id']);
    }

    public static function getStatusList() {
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
