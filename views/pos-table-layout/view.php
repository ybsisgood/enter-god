<?php

use app\models\PosTableLayout;
use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PosTableLayout $model */
/** @var app\models\PosOutlet $outlet */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pos Outlets', 'url' => ['pos-outlet/index']];
$this->params['breadcrumbs'][] = ['label' => $outlet->name, 'url' => ['pos-outlet/view', 'id' => $outlet->id, 'slug_url' => $outlet->slug_url]];    
$this->params['breadcrumbs'][] = ['label' => 'Table Layouts', 'url' => ['index', 'outletID' => $outlet->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
}
?>
<div class="pos-table-layout-view">
    <p>
        <?= Html::a('Back', ['index', 'outletID' => $outlet->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => 'Outlet',
                'value' => $outlet->name,
            ],
            [
                'label' => 'Positioning',
                'format' => 'raw',
                'value' => json_encode($model->positioning, JSON_PRETTY_PRINT),
            ],
            'layout',
            [
                'label' => 'Status',
                'value' => PosTableLayout::getStatusList()[$model->status],
            ],
            [
                'label' => 'Change Log',
                'format' => 'raw',
                'value' => $text
            ]
        ],
    ]) ?>

</div>
