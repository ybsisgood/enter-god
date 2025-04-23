<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property int $sso_id
 * @property string $pin
 * @property string|null $rfid
 * @property int $status 0: Inactive, 1: Active, 2: Draft, 3: Completed, 4: Deleted, 5: Maintenance
 * @property string $detail_info
 * @property string $username
 */
class PosUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
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
            [['name', 'sso_id', 'pin', 'username'], 'required'],
            [['sso_id', 'status'], 'default', 'value' => null],
            [['sso_id', 'status'], 'integer'],
            [['rfid', 'detail_info'], 'safe'],
            [['name', 'pin'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 32],
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
            'sso_id' => 'Sso ID',
            'pin' => 'Pin',
            'rfid' => 'Rfid',
            'status' => 'Status',
            'detail_info' => 'Detail Info',
            'username' => 'Username',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PosUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PosUserQuery(get_called_class());
    }
}
