<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property int $app_id
 * @property string $name
 * @property string $code_roles
 * @property int $status
 * @property string|null $detail_info
 * @property string|null $permission_json
 */
class Roles extends \yii\db\ActiveRecord
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
        return 'roles';
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
            [['app_id', 'name', 'code_roles', 'status'], 'required'],
            [['app_id', 'status'], 'integer'],
            [['detail_info', 'permission_json'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['code_roles'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App Name',
            'name' => 'Name',
            'code_roles' => 'Code Roles',
            'status' => 'Status',
            'detail_info' => 'Detail Info',
            'permission_json' => 'Permission Json',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\RolesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RolesQuery(get_called_class());
    }

    public function getApps() {
        return $this->hasOne(Apps::class, ['id' => 'app_id']);
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
