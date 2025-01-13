<?php

use app\models\Apps;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\AppsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Apps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apps-index">
    <p>
        <?= Html::a('Create Apps', ['create'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
        <?= Html::a('List Deleted', ['list-deleted'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <?= Html::a('reset filter', ['index'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1']) ?>
                        </div>
                    </div>
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
                                'template' => '{view} {update} {delete}',
                                'width' => '200px',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-eye"></i>', ['view', 'seo_url' => $model->seo_url], [
                                            'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                            'title' => 'View',
                                        ]);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'seo_url' => $model->seo_url], [
                                            'class' => 'btn btn-sm btn-info waves-effect waves-light',
                                            'title' => 'Update',
                                        ]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                                            'class' => 'btn btn-sm btn-danger waves-effect waves-light',
                                            'title' => 'Delete',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
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
