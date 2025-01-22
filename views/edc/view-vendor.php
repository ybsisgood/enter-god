<?php 

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
/** @var yii\web\View $this */
/** @var app\models\PaymentVendor $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Vendors', 'url' => ['vendor']];
$this->params['breadcrumbs'][] = $this->title;

$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
}
?>
<div class="payment-vendor-view">
    <p>
        <?= Html::a('Back', ['vendor'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update-vendor', 'id' => $model->id], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete-vendor', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post', 
        ]]); ?>
    </p>
    
    <div class="row mb-2">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'code',
                            [
                                'attribute' => 'wallet',
                                'value' => number_format($model->wallet, 2)
                            ],
                            [
                                'attribute' => 'status',
                                'value' => $model->getStatusList()[$model->status],
                            ],
                            [
                                'label' => 'Change Log',
                                'format' => 'raw',
                                'value' => $text
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p>Log History Wallet</p>
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
                            [
                                'attribute' => 'payment_vendor_id',
                                'label' => 'Vendor Name',
                                'filter' => false,
                                'value' => function ($mod) use ($model) {
                                    return $model->name;
                                }
                            ],
                            [
                                'attribute' => 'type',
                                'filter' => $searchModel->getTypeList(),
                                'value' => function ($mod) {
                                    return $mod->getTypeList()[$mod->type];
                                }
                            ],
                            'note_wallet:ntext',
                            [
                                'attribute' => 'wallet_before',
                                'value' => function ($mod) {
                                    return number_format($mod->wallet_before, 2);
                                }
                            ],
                            [
                                'attribute' => 'amount',
                                'value' => function ($mod) {
                                    return number_format($mod->amount, 2);
                                }
                            ],
                            [
                                'attribute' => 'wallet_after',
                                'value' => function ($mod) {
                                    return number_format($mod->wallet_after, 2);
                                }
                            ],
                            'created_date',
                            //'wallet_after',
                            //'created_date',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>