<?php

use app\models\PaymentVendor;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PaymentVendorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'List Deleted Vendors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-vendor-index">

    <p>
        <?= Html::a('List Vendor', ['vendor'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::a('reset filter', ['vendor'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1 float-end']) ?>
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
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return PaymentVendor::getStatusList()[$model->status];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{restore}',
                        'width' => '200px',
                        'buttons' => [
                            'restore' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash-restore"></i>', ['restore-vendor', 'id' => $model->id], [
                                    'title' => 'Restore',
                                    'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to restore this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            }
                        ]
                    ]
                ],
            ]); ?>
        </div>
    </div>


</div>
