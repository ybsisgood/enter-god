<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "serial_keys".
 *
 * @property int $id
 * @property string $name
 * @property string|null $activation_code
 * @property string|null $local_code
 * @property int $outlet_id
 * @property int $status
 * @property string|null $detail_info
 */
class SerialKeys extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'serial_keys';
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
            [['name', 'outlet_id'], 'required'],
            [['outlet_id', 'status'], 'integer'],
            [['detail_info'], 'safe'],
            [['name', 'activation_code'], 'string', 'max' => 255],
            [['local_code'], 'string', 'max' => 32],
            [['activation_code'], 'unique'],
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
            'activation_code' => 'Activation Code',
            'local_code' => 'Local Code',
            'outlet_id' => 'Outlet ID',
            'status' => 'Status',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\SerialKeysQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SerialKeysQuery(get_called_class());
    }
}
