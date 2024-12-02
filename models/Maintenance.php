<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maintenance".
 *
 * @property int $id
 * @property int $status
 * @property string|null $message
 */
class Maintenance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maintenance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['message'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'message' => 'Message',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\MaintenanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\MaintenanceQuery(get_called_class());
    }
}
