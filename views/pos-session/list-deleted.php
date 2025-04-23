<?php

use app\models\PosSession;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PosSessionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pos Sessions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pos-session-index">

    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                            [
                                'attribute' => 'outletName',
                                'value' => function($model) {
                                    return $model->posOutlet?->name;
                                }
                            ],
                            [
                                'attribute' => 'open_date',
                                'filter' => false
                            ],
                            [
                                'attribute' => 'closed_date',
                                'filter' => false
                            ],
                            [
                                'attribute' => 'status',
                                'filter' => [PosSession::STATUS_ACTIVE => 'Active', PosSession::STATUS_INACTIVE => 'Inactive',PosSession::STATUS_COMPLETED => 'Completed'],
                                'value' => function($model) {
                                    return PosSession::getStatusList()[$model->status];
                                }
                            ],
                            //'slave_id',
                            //'sync_slave',
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'template' => '{restore}',
                                'width' => '100px',
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
