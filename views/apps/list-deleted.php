<?php

use app\models\Apps;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\AppsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'List Apps Deleted';
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apps-index">
    <p>
        <?= Html::a('List Apps', ['index'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'responsiveWrap' => false,
                        'options' => [
                            'id' => 'align-items-middle'
                        ],
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn'],

                            // 'id',
                            'name',
                            'description:ntext',
                            'code_app',
                            [
                                'attribute' => 'status',
                                'filter' => Apps::getStatusList(),
                                'value' => function ($model) {
                                    return Apps::getStatusList()[$model->status];
                                }
                            ],
                            //'status_env',
                            //'pic',
                            //'live_date',
                            //'detail_info',
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'template' => '{restore}',
                                'width' => '100px',
                                'buttons' => [
                                    'restore' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-trash-restore"></i>', ['restore', 'id' => $model->id], [
                                            'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                            'title' => 'Restore',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to restore this item?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    
</div>
