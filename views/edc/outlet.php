<?php

use app\models\Outlets;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\OutletsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Outlets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outlets-index">

    <p>
        <?= Html::a('Create Outlets', ['create-outlet'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
        <?= Html::a('List Deleted', ['list-deleted-outlet'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::a('reset filter', ['outlet'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1 float-end']) ?>
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
                    [
                        'attribute' => 'address',
                        'value' => function ($model) {
                            return $model->detail_info['address'] ?? ' - ';
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => Outlets::getStatusList(),
                        'value' => function ($model) {
                            return Outlets::getStatusList()[$model->status];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fa fa-eye"></span>', ['view-outlet', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'View'),
                                    'class' => 'btn btn-primary btn-sm',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil-alt"></span>', ['update-outlet', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'Update'),
                                    'class' => 'btn btn-success btn-sm',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span>', ['delete-outlet', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data-pjax' => '0',
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ]
                    ]
                    // 'detail_info',
                    
                ],
            ]); ?>
        </div>
    </div>

</div>
