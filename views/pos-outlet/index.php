<?php

use app\models\PosOutlet;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PosOutletSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pos Outlets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pos-outlet-index">

    <p>
        <?= Html::a('Create Pos Outlet', ['create'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
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
                                'code',
                                // 'slug_url:url',
                                // 'address:ntext',
                                [
                                    'attribute' => 'location_lat',
                                    'value' => function ($model) {
                                        return $model->location['lat'] ?? null;
                                    }
                                ],
                                [
                                    'attribute' => 'location_lng',
                                    'value' => function ($model) {
                                        return $model->location['lng'] ?? null;
                                    }
                                ],
                                // 'hwid_server',
                                // 'secret_key',
                                // 'ip_whitelist',
                                // 'slave_id',
                                // 'sync_slave',
                                [
                                    'attribute' => 'status',
                                    'filter' => PosOutlet::getStatusList(),
                                    'value' => function ($model) {
                                        return PosOutlet::getStatusLabel()[$model->status];
                                    }
                                ],
                                //'detail_info',
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'template' => '{view} {update} {delete}',
                                    'width' => '200px',
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id, 'slug_url' => $model->slug_url], [
                                                'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                                'title' => 'View',
                                            ]);
                                        },
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id, 'slug_url' => $model->slug_url], [
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

</div>
