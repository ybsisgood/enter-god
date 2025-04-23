<?php

use app\models\PosTableLayout;
use yii\helpers\Html;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PosTableLayoutSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Deleted Table Layouts (' . $outlet->name . ')';
$this->params['breadcrumbs'][] = ['label' => $outlet->name, 'url' => ['pos-outlet/view', 'id' => $outlet->id, 'slug_url' => $outlet->slug_url]];
$this->params['breadcrumbs'][] = ['label' => 'Table Layouts', 'url' => ['index', 'outletID' => $outlet->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="pos-table-layout-index">

    <p>
        <?= Html::a('Back', ['index', 'outletID' => $outlet->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
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

                            'name',
                            'layout',
                            [
                                'label' => 'Positioning',
                                'format' => 'raw',
                                'value' => function($model) {
                                    return json_encode($model->positioning, JSON_PRETTY_PRINT);
                                }
                            ],
                            [
                                'attribute' => 'status',
                                'filter' => false,
                                'value' => function($model) {
                                    return PosTableLayout::getStatusList()[$model->status];
                                }
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'template' => '{restore}',
                                'width' => '100px',
                                'buttons' => [
                                    'restore' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-undo"></i>', ['restore', 'id' => $model->id], [
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
