<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "table_layout".
 *
 * @property int $id
 * @property string $name
 * @property string|null $positioning
 * @property int $outlet_id
 * @property int|null $layout
 * @property int $status 0: Inactive, 1: Active, 2: Draft, 3: Completed, 4: Deleted, 5: Maintenance
 * @property string $detail_info
 */
class PosTableLayout extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_DELETED = 4;
    const STATUS_MAINTENANCE = 5;

    public $layout_x;
    public $layout_y;
    public $layout_size_x;
    public $layout_size_y;
    public $layout_shape;

    const LAYOUT_SHAPE_SQUARE = 'square';
    const LAYOUT_SHAPE_CIRCLE = 'circle';
    const LAYOUT_SHAPE_RECTANGLE = 'rectangle';
    const LAYOUT_SHAPE_HEXAGON = 'hexagon';
    const LAYOUT_SHAPE_OCTAGON = 'octagon';
    const LAYOUT_SHAPE_PENTAGON = 'pentagon';
    const LAYOUT_SHAPE_TRIANGLE = 'triangle';
    const LAYOUT_SHAPE_POLYGON = 'polygon';

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'table_layout';
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
            [['name', 'outlet_id', 'layout', 'status', 'layout_x', 'layout_y', 'layout_size_x', 'layout_size_y', 'layout_shape'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['positioning', 'detail_info'], 'safe'],
            [['outlet_id', 'layout', 'status'], 'default', 'value' => null],
            [['outlet_id', 'layout', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'positioning' => 'Positioning',
            'outlet_id' => 'Outlet ID',
            'layout' => 'Layout',
            'status' => 'Status',
            'detail_info' => 'Detail Info',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PosTableLayoutQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PosTableLayoutQuery(get_called_class());
    }

    public function getOutlet()
    {
        return $this->hasOne(PosOutlet::className(), ['id' => 'outlet_id']);
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_MAINTENANCE => 'Maintenance',
        ];
    }

    public static function getShapeList()
    {
        return [
            self::LAYOUT_SHAPE_SQUARE => 'Square',
            self::LAYOUT_SHAPE_CIRCLE => 'Circle',
            self::LAYOUT_SHAPE_RECTANGLE => 'Rectangle',
            self::LAYOUT_SHAPE_HEXAGON => 'Hexagon',
            self::LAYOUT_SHAPE_OCTAGON => 'Octagon',
            self::LAYOUT_SHAPE_PENTAGON => 'Pentagon',
            self::LAYOUT_SHAPE_TRIANGLE => 'Triangle',
            self::LAYOUT_SHAPE_POLYGON => 'Polygon',
        ];
    }


}
