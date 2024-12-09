<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apps".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $code_app
 * @property int $status
 * @property int $status_env 1:dev, 2: prod, 3: testing, 4: deprecated
 * @property string|null $pic
 * @property string|null $live_date
 * @property string|null $detail_info
 * @property string|null $seo_url
 * @property string|null $whitelist_ip
 * @property string|null $whitelist_domain
 */
class Apps extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DRAFT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DELETED = 4;
    const STATUS_MAINTENANCE = 5;

    const STATUS_ENV_DEV = 1;
    const STATUS_ENV_PROD = 2;
    const STATUS_ENV_TESTING = 3;
    const STATUS_ENV_DEPRECATED = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apps';
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
            [['name', 'status', 'status_env'], 'required'],
            [['description'], 'string'],
            [['status', 'status_env'], 'integer'],
            [['live_date', 'detail_info'], 'safe'],
            [['name', 'code_app', 'seo_url'], 'string', 'max' => 255],
            [['whitelist_ip', 'whitelist_domain'], 'string', 'max' => 500],
            [['pic'], 'string', 'max' => 150],
            [['pic', 'live_date', 'whitelist_domain', 'whitelist_ip'], 'default', 'value' => null, 'skipOnError' => true],
            [['status_env', 'status'], 'filter', 'filter' => 'intval'],
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
            'description' => 'Description',
            'code_app' => 'Code App',
            'status' => 'Status',
            'status_env' => 'Status Environment',
            'pic' => 'Pic',
            'live_date' => 'Live Date',
            'detail_info' => 'Detail Info',
            'seo_url' => 'Seo Url',
            'whitelist_ip' => 'Whitelist Ip',
            'whitelist_domain' => 'Whitelist Domain',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AppsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AppsQuery(get_called_class());
    }

    public static function getEnvList()
    {
        return [
            self::STATUS_ENV_DEV => 'Dev',
            self::STATUS_ENV_PROD => 'Prod',
            self::STATUS_ENV_TESTING => 'Testing',
            self::STATUS_ENV_DEPRECATED => 'Deprecated',
        ];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_MAINTENANCE => 'Maintenance',
        ];
    }

    public static function getStatusFilterList()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_MAINTENANCE => 'Maintenance',
        ];
    }

    public static function getStatusEnvList()
    {
        return [
            self::STATUS_ENV_DEV => 'Dev',
            self::STATUS_ENV_PROD => 'Prod',
            self::STATUS_ENV_TESTING => 'Testing',
            self::STATUS_ENV_DEPRECATED => 'Deprecated',
        ];
    }
}
