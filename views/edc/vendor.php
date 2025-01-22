<?php

use app\models\PaymentVendor;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PaymentVendorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Payment Vendors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-vendor-index">

    <p>
        <?= Html::a('Create Payment Vendor', ['create-vendor'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
        <?= Html::a('List Deleted', ['list-deleted-vendor'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
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
                        'attribute' => 'Wallet',
                        'value' => function ($model) {
                            return number_format($model->wallet, 2);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return PaymentVendor::getStatusList()[$model->status];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', ['view-vendor', 'id' => $model->id], [
                                    'title' => 'View',
                                    'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-edit"></i>', ['update-vendor', 'id' => $model->id], [
                                    'title' => 'Update',
                                    'class' => 'btn btn-sm btn-success waves-effect waves-light',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash-alt"></i>', ['delete-vendor', 'id' => $model->id], [
                                    'title' => 'Delete',
                                    'class' => 'btn btn-sm btn-danger waves-effect waves-light',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
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
