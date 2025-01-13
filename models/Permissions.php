<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permissions".
 *
 * @property int $id
 * @property int $app_id
 * @property int $permission_group_id
 * @property string $name
 * @property string|null $code_permissions
 * @property int $status
 * @property string|null $detail_info
 */
class Permissions extends \yii\db\ActiveRecord
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
        return 'permissions';
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
            [['app_id', 'permission_group_id', 'name', 'status', 'code_permissions'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['app_id', 'permission_group_id', 'status'], 'integer'],
            [['detail_info'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['code_permissions'], 'string', 'max' => 50],
            [['code_permissions'], 'match', 'pattern' => '/^[a-zA-Z]+$/'],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DRAFT, self::STATUS_COMPLETED, self::STATUS_DELETED]],
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
            'permission_group_id' => 'Permission Group ID',
            'name' => 'Name',
            'code_permissions' => 'Code Permissions',
            'status' => 'Status',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PermissionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PermissionsQuery(get_called_class());
    }

    public function getApps() {
        return $this->hasOne(Apps::className(), ['id' => 'app_id']);
    }
    
    public function getPermissionGroups() {
        return $this->hasOne(PermissionGroups::className(), ['id' => 'permission_group_id']);
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
