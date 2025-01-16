<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PaymentCategories $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Categories', 'url' => ['category']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>';
}
?>
<div class="payment-categories-view">

    <p>
        <?= Html::a('Back', ['category'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update-category', 'id' => $model->id], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update Image', ['update-image-category', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete-category', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'sort',
                    [
                        'attribute' => 'image_url',
                        'format' => 'raw',
                        'value' => $model->image_url ? Html::img(Yii::$app->params['domainImageCategory'].$model->image_url, ['width' => '200px']) : Html::img(Yii::$app->params['imagePlaceholderCategory'], ['width' => '200px']),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => $model->getStatusList()[$model->status],
                    ],
                    [
                        'label' => 'detail_info',
                        'format' => 'raw',
                        'value' => $text
                    ]
                ],
            ]) ?>
        </div>
    </div>

</div>
