<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string $username
 * @property string|null $name
 * @property string|null $email
 * @property string|null $auth_key
 * @property string $password_hash
 * @property string|null $confirmation_token
 * @property int $status
 * @property string|null $registration_ip
 * @property string|null $bind_to_ip
 * @property string|null $detail_info
 */
class Employees extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DELETED = 4;
    const STATUS_MAINTENANCE = 5;

    public $password;
    public $newPassword;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CHANGE_PASSWORD = 'change_password';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
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
            [['username', 'name', 'email', 'password', 'status'], 'required', 'on' => self::SCENARIO_CREATE],
            [['email', 'name', 'status'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['password', 'newPassword'], 'string', 'min' => 6, 'max' => 32],
            [['password', 'newPassword'], 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[A-Z]).*$/',
            'message' => 'Password must contain at least one number and one uppercase letter.'],
            [['newPassword'], 'required', 'on' => self::SCENARIO_CHANGE_PASSWORD],
            [['status'], 'integer'],
            [['detail_info'], 'safe'],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]*$/', 'message' => 'Only letters and numbers are allowed'],
            [['email'], 'email'],
            [['username'], 'string', 'max' => 32],
            [['name', 'password_hash', 'confirmation_token', 'email'], 'string', 'max' => 255],
            [['name', 'registration_ip', 'confirmation_token', 'email', 'bind_to_ip', 'detail_info'], 'default', 'value' => null, 'skipOnError' => true],
            [['auth_key'], 'string', 'max' => 32],
            [['registration_ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'confirmation_token' => 'Confirmation Token',
            'status' => 'Status',
            'registration_ip' => 'Registration Ip',
            'bind_to_ip' => 'Bind To Ip',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\EmployeesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EmployeesQuery(get_called_class());
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DRAFT => 'Banned',
            // self::STATUS_COMPLETED => 'Completed',
            // self::STATUS_DELETED => 'Deleted',
            // self::STATUS_MAINTENANCE => 'Maintenance',
        ];
    }
}
