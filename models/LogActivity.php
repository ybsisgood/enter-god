<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_activity".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $tables_name
 * @property string|null $description
 * @property string $created_at
 * @property string|null $detail_info
 */
class LogActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'detail_info'], 'safe'],
            [['tables_name'], 'string', 'max' => 250],
            [['description'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tables_name' => 'Tables Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AQuery(get_called_class());
    }
}
