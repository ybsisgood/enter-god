<?php

use app\models\PosTableLayout;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PosTableLayoutSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Table Layouts : ' . $outlet->name;
$this->params['breadcrumbs'][] = ['label' => 'Pos Outlets', 'url' => ['pos-outlet/index']];
$this->params['breadcrumbs'][] = ['label' => $outlet->name, 'url' => ['pos-outlet/view', 'id' => $outlet->id, 'slug_url' => $outlet->slug_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pos-table-layout-index">

    <p>
        <?= Html::a('Back', ['pos-outlet/view', 'id' => $outlet->id, 'slug_url' => $outlet->slug_url], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Create Table Layout', ['create', 'outletID' => $outlet->id], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin'): ?>
            <?= Html::a('List Deleted', ['list-deleted', 'outletID' => $outlet->id], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <?= Html::a('reset filter', ['index', 'outletID' => $outlet->id], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1']) ?>
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

                            'name',
                            // [
                            //     'attribute' => 'outletName',
                            //     'value' => function($model) {
                            //         return $model->outlet?->name;
                            //     },
                            // ],
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
                                'filter' => [PosTableLayout::STATUS_ACTIVE => 'Active', PosTableLayout::STATUS_INACTIVE => 'Inactive'],
                                'value' => function($model) {
                                    return PosTableLayout::getStatusList()[$model->status];
                                }
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'template' => '{view} {update} {delete}',
                                'width' => '200px',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], [
                                            'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                            'title' => 'View',
                                        ]);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id], [
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
