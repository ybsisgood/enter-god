<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PaymentChannels $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Channels', 'url' => ['channel']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= $key . ' : ' . $value . '<br>';
}

?>
<div class="payment-channels-view">

    <p>
        <?= Html::a('Back', ['channel'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update-channel', 'id' => $model->id], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update Image', ['update-image-channel', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete-channel', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
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
                            'attribute' => 'image_url',
                            'format' => 'raw',
                            'value' => $model->image_url ? Html::img(Yii::$app->params['domainImageChannel'].$model->image_url, ['width' => '200px']) : Html::img(Yii::$app->params['imagePlaceholderChannel'], ['width' => '200px']),
                        ],
                        [
                            'label' => 'Category',
                            'value' => $model->paymentCategory->name
                        ],
                        [
                            'attribute' => 'status',
                            'value' => $model->getStatusList()[$model->status],
                        ],
                        'sort',
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
