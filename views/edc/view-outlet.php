<?php

use app\models\Outlets;
use app\models\PaymentCategories;
use app\models\PaymentChannels;
use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Outlets $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Outlets', 'url' => ['outlet']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>';
}
?>
<div class="outlets-view">

    <p>
        <?= Html::a('Back', ['outlet'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update-outlet', 'id' => $model->id], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Sort Category', ['sort-outlet-category', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Sort Channel', ['sort-outlet-channel', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete-outlet', 'id' => $model->id], [
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
                            [
                                'label' => 'Address',
                                'value' => $model->detail_info['address'] ?? ' - '
                            ],
                            [
                                'attribute' => 'status',
                                'value' => Outlets::getStatusList()[$model->status]
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
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5>List Payment Category</h5>
                            <?php foreach ($model->detail_info['payment_category'] ?? [] as $key => $value) : ?>
                                <ul class="list-group list-group-flush">
                                    <li>
                                        <?= PaymentCategories::findOne($value)?->name ?> | <?= PaymentCategories::getStatusList()[PaymentCategories::findOne($value)?->status] ?>
                                    </li>
                                </ul>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <h5>List Payment Channel</h5>
                            <?php foreach ($model->detail_info['payment_channel'] ?? [] as $key => $value) : ?>
                                <ul class="list-group list-group-flush">
                                    <li>
                                        <?= PaymentChannels::findOne($value)?->name ?> | <?= PaymentChannels::getStatusList()[PaymentChannels::findOne($value)?->status] ?>
                                    </li>
                                </ul>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
