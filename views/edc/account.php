<?php

use app\models\PaymentAccounts;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PaymentAccountsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Payment Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-accounts-index">

    <p>
        <?= Html::a('Create Payment Accounts', ['create-account'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Sort Payment Accounts', ['sort-account'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
            <?= Html::a('List Deleted', ['list-deleted-account'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::a('reset filter', ['account'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1 float-end']) ?>
                </div>
            </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsiveWrap' => false,
                'options' => [
                    'class' => 'align-items-middle'
                ],
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    // 'id',
                    'name',
                    [
                        'attribute' => 'sort',
                        'hAlign' => 'center',
                        'width' => '75px',
                    ],
                    [
                        'attribute' => 'nameVendor',
                        'value' => function ($model) {
                            return $model->detail_info['vendor']['name'] ?? 'no set';
                        }
                    ],
                    [
                        'attribute' => 'nameCategory',
                        'value' => function ($model) {
                            return $model->detail_info['category']['name'] ?? 'no set';
                        }
                    ],
                    [
                        'attribute' => 'nameChannel',
                        'value' => function ($model) {
                            return $model->detail_info['channel']['name'] ?? 'no set';
                        }
                    ],
                    // 'detail_keys',
                    'extra_code',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return $model->getStatusList()[$model->status];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fa fa-eye"></i>', ['view-account', 'id' => $model->id], ['class' => 'btn btn-sm btn-info']);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fa fa-edit"></i>', ['update-account', 'id' => $model->id], ['class' => 'btn btn-sm btn-success']);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fa fa-trash"></i>', ['delete-account', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ]
                    ],
                    //'mdr_percent',
                    //'mdr_price',
                    //'min_payment',
                    //'max_payment',
                    //'free_mdr_min',
                    //'free_mdr_max',
                    //'detail_info',
                    //'how_to_payment:ntext',
                    //'limit_days',
                    //'limit_month',
                    //'limit_year',
                    //'secret_code',
                ],
            ]); ?>
        </div>
    </div>


</div>
