<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_categories".
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 * @property string|null $image_url
 * @property int $status
 * @property string|null $detail_info
 */
class PaymentCategories extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DELETED = 4;
    const STATUS_MAINTENANCE = 5;

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_SORT = 'sort';
    const SCENARIO_UPLOAD_IMAGE = 'upload_image';

    public $imageFile;
    public $sortCategory;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_categories';
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
            [['name', 'status'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['sort', 'status'], 'integer'],
            ['sortCategory', 'safe'],
            [['sortCategory'], 'required', 'on' => self::SCENARIO_SORT],
            [['detail_info'], 'safe'],
            [['name', 'image_url'], 'string', 'max' => 255],
            [['image_url'], 'default', 'value' => null, 'skipOnError' => true],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'svg', 'maxSize' => 1024 * 1024 * 0.5],
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
            'sort' => 'Sort',
            'image_url' => 'Image Url',
            'status' => 'Status',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PaymentCategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PaymentCategoriesQuery(get_called_class());
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
