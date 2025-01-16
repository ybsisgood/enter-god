<?php 

use yii\helpers\Html;
use kartik\detail\DetailView;
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
    
    <div class="row">
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
</div>