<?php

use app\models\PosOutlet;
use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PosOutlet $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pos Outlets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
}
?>
<div class="pos-outlet-view">
    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'slug_url' => $model->slug_url], ['class' => 'btn btn-info btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
                            // 'slug_url:url',
                            'address:ntext',
                            'location_lat',
                            'location_lng',
                            'hwid_server',
                            'secret_key',
                            'ip_whitelist',
                            'slave_id',
                            // 'sync_slave',
                            [
                                'attribute' => 'status',
                                'value' => PosOutlet::getStatusLabel()[$model->status],
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
