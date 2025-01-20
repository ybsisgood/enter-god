<?php

use app\models\Payments;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PaymentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Completed Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index">

    <p>
        <?= Html::a('Waiting Payment', ['payment'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Completed Payment', ['payment-completed'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Expired Payment', ['payment-expired'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Refund Payment', ['payment-refund'], ['class' => 'btn btn-warning btn-sm waves-effect waves-light']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">

                </div>
                <div class="col-12 col-md-6">
                    <?= Html::a('Reset Filter', ['payment'], ['class' => 'btn btn-outline-primary mb-1 btn-sm waves-effect waves-light float-end']) ?>
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
                        'invoice_number',
                        'remark',
                        [
                            'header' => 'Outlet',
                            'attribute' => 'outletName',
                            'value' => function ($model) {
                                return $model->detail_payment['outlet'] ?? '';
                            }
                        ],
                        [
                            'header' => 'Vendor',
                            'attribute' => 'vendorName',
                            'value' => function ($model) {
                                return $model->detail_payment['vendor'] ?? '';
                            }
                        ],
                        [
                            'header' => 'Category',
                            'attribute' => 'categoryName',
                            'value' => function ($model) {
                                return $model->detail_payment['category'] ?? '';
                            }
                        ],
                        [
                            'header' => 'Channel',
                            'attribute' => 'channelName',
                            'value' => function ($model) {
                                return $model->detail_payment['channel'] ?? '';
                            }
                        ],
                        [
                            'header' => 'Device',
                            'attribute' => 'deviceName',
                            'value' => function ($model) {
                                return $model->detail_payment['device'] ?? '';
                            }
                        ],
                        [
                            'header' => 'Created By',
                            'attribute' => 'createdBy',
                            'value' => function ($model) {
                                return $model->detail_info['changelog']['created_by'] ?? '';
                            }
                        ],
                        [
                            'header' => 'Payment Date',
                            'value' => function ($model) {
                                return $model->expired_at ? date('H:i - d-m-Y', strtotime($model->expired_at)) : '';
                            }
                        ],
                        [
                            'header' => 'Total Payment',
                            'hAlign' => 'right',
                            'value' => function ($model) {
                                return number_format($model->total, 2, '.', ',');
                            }
                        ],
                        [
                            'header' => 'MDR',
                            'hAlign' => 'right',
                            'value' => function ($model) {
                                return number_format($model->mdr, 2, '.', ',');
                            }
                        ],
                        [
                            'header' => 'Our Wallet',
                            'hAlign' => 'right',
                            'value' => function ($model) {
                                return number_format($model->subtotal, 2, '.', ',');
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'filter' => false,
                            'value' => function ($model) {
                                return Payments::getStatusList()[$model->status];
                            }
                        ]
                        // 'payment_channel_id',
                        // 'payment_vendor_id',
                        // 'payment_category_id',
                        // 'serial_key_id',
                        // 'outlet_id',
                        // 'subtotal',
                        // 'mdr',
                        // 'total',
                        //'status',
                        //'created_at',
                        //'expired_at',
                        //'payment_at',
                        //'detail_payment',
                        //'detail_info',
                        
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
