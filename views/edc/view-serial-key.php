<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SerialKeys $model */

$this->title = 'Serial Key: '. $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Serial Keys', 'url' => ['serial-key']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
foreach($model->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>';
}
?>
<div class="serial-keys-view">

    <p>
        <?= Html::a('Back', ['serial-key'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
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
                            [
                                'attribute' => 'outlet_id',
                                'label' => 'Outlet',
                                'value' => $model->outlet->name
                            ],
                            'name',
                            'activation_code',
                            'local_code',
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
