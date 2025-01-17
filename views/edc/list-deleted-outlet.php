<?php

use app\models\Outlets;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\OutletsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'List Deleted Outlets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outlets-index">

    <p>
        <?= Html::a('List Outlets', ['outlet'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
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
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return Outlets::getStatusList()[$model->status];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{restore}',
                        'width' => '200px',
                        'buttons' => [
                            'restore' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash-restore"></i>', ['restore-outlet', 'id' => $model->id], [
                                    'class' => 'btn btn-primary btn-sm waves-effect waves-light',
                                    'title' => 'Restore',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to restore this item?',
                                        'method' => 'post'
                                    ]
                                ]);
                            }
                        ]
                    ]
                    // 'detail_info',
                    
                ],
            ]); ?>
        </div>
    </div>

</div>
