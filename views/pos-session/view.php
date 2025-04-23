<?php

use app\models\PosSession;
use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PosSession $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pos Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
}
?>
<div class="pos-session-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
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
                'attribute' => 'outlet_id',
                'value' => function($model) {
                    return $model->posOutlet->name;
                }
            ],
            'open_date',
            'closed_date',
            [
                'attribute' => 'status',
                'value' => PosSession::getStatusList()[$model->status],
            ],
            [
                'label' => 'Change Log',
                'format' => 'raw',
                'value' => $text
            ]
        ],
    ]) ?>

</div>
