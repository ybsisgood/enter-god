<?php

use app\models\PosOutlet;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PosOutletSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pos Outlets Deleted';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pos-outlet-index">

    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
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
                                    'template' => '{restore}',
                                    'width' => '150px',
                                    'buttons' => [
                                        'restore' => function ($url, $model, $key) {
                                            return Html::a('<i class="fas fa-undo-alt"></i>', $url, [
                                                'class' => 'btn btn-sm btn-danger waves-effect waves-light',
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

</div>
