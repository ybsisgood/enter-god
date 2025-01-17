<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PaymentAccounts $model */

$this->title = 'Payment Account : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Accounts', 'url' => ['account']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$stringKey = json_encode($model->detail_keys ?? [], JSON_PRETTY_PRINT);

$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= $key . ' : ' . $value . '<br>';
}
?>
<div class="payment-accounts-view">

    <p>
        <?= Html::a('Back', ['account'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update-account', 'id' => $model->id], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete-account', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'name',
                                        'valueColOptions' => [
                                            'style' => 'width: 30%',
                                        ],
                                    ],
                                    [
                                        'attribute' => 'id',
                                        'valueColOptions' => [
                                            'style' => 'width: 30%',
                                        ],
                                    ]
                                ]
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'payment_vendor_id',
                                        'label' => 'Payment Vendor',
                                        'valueColOptions' => [
                                            'style' => 'width: 30%',
                                        ],
                                        'value' => $model->paymentVendor->name
                                    ],
                                    [
                                        'attribute' => 'payment_vendor_id',
                                        'valueColOptions' => [
                                            'style' => 'width: 30%',
                                        ],
                                    ]
                                ]
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'payment_category_id',
                                        'label' => 'Payment Category',
                                        'valueColOptions' => [
                                            'style' => 'width: 30%',
                                        ],
                                        'value' => $model->paymentCategory->name
                                    ],
                                    [
                                        'attribute' => 'payment_category_id',
                                        'valueColOptions' => [
                                            'style' => 'width: 30%',
                                        ],
                                    ]
                                ]
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'payment_channel_id',
                                        'label' => 'Payment Channel',
                                        'valueColOptions' => [
                                            'style' => 'width: 30%',
                                        ],
                                        'value' => $model->paymentChannel->name
                                    ],
                                    [
                                        'attribute' => 'payment_channel_id',
                                        'valueColOptions' => [
                                            'style' => 'width: 30%',
                                        ],
                                    ]
                                ]
                            ],
                            'extra_code',
                            'sort',
                            [
                                'label' => 'detail_key',
                                'value' => $stringKey
                            ],
                            [
                                'attribute' => 'status',
                                'value' => $model->getStatusList()[$model->status]
                            ],
                            [
                                'attribute' => 'how_to_payment',
                                'format' => 'raw',
                                'value' => $model->how_to_payment
                            ],
                            [
                                'attribute' => 'secret_code',
                                'value' => $model->secret_code
                            ],
                            [
                                'label' => 'Change Log',
                                'format' => 'raw',
                                'value' => $text
                            ]
                            // 'status',
                            // 'payment_category_id',
                            
                            // 'mdr_percent',
                            // 'mdr_price',
                            // 'min_payment',
                            // 'max_payment',
                            // 'free_mdr_min',
                            // 'free_mdr_max',
                            // 'sort',
                            // 'detail_info',
                            // 'how_to_payment:ntext',
                            // 'limit_days',
                            // 'limit_month',
                            // 'limit_year',
                            // 'secret_code',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card">
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'mdr_percent',
                                'value' => number_format($model->mdr_percent, 2).'%',
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],
                            [
                                'attribute' => 'mdr_price',
                                'value' => number_format($model->mdr_price, 2),
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],
                            [
                                'attribute' => 'min_payment',
                                'value' => number_format($model->min_payment, 2),
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],
                            [
                                'attribute' => 'max_payment',
                                'value' => number_format($model->max_payment, 2),
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],
                            [
                                'attribute' => 'free_mdr_min',
                                'value' => number_format($model->free_mdr_min, 2),
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],
                            [
                                'attribute' => 'free_mdr_max',
                                'value' => number_format($model->free_mdr_max, 2),
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],
                            [
                                'attribute' => 'limit_days',
                                'value' => $model->limit_days ? number_format($model->limit_days, 2) : 'Unlimited',
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],
                            [
                                'attribute' => 'limit_month',
                                'value' => $model->limit_month ? number_format($model->limit_month, 2) : 'Unlimited',
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],
                            [
                                'attribute' => 'limit_year',
                                'value' => $model->limit_year ? number_format($model->limit_year, 2) : 'Unlimited',
                                'valueColOptions' => [
                                    'style' => 'width: 30%',
                                ],
                            ],

                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
