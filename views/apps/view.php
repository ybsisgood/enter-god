<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Apps;

/** @var yii\web\View $this */
/** @var app\models\Apps $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
}
?>
<div class="apps-view">

    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-success waves-effect waves-light']) ?>
        <?= Html::a('Roles', ['roles', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-outline-primary waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete', 'seo_url' => $model->seo_url], [
            'class' => 'btn btn-sm btn-danger waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'columns' => [
                                [
                                    'attribute' => 'name',
                                    'format' => 'raw',
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ],
                                [
                                    'attribute' => 'code_app',
                                    'format' => 'raw',
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ]
                            ]
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'status',
                                    'value' => Apps::getStatusList()[$model->status],
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ],
                                [
                                    'attribute' => 'status_env',
                                    'value' => Apps::getEnvList()[$model->status_env],
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ]
                            ]
                        ],
                        'description:ntext',
                        'pic',
                        'live_date',
                        [
                            'label' => 'Change Log',
                            'format' => 'raw',
                            'value' => $text
                        ]
                    ],
                ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
