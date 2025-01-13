<?php

use app\models\Employees;
use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Employees $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$bindText = '';

foreach ($model->bind_to_ip ?? [] as $key => $value) {
    $bindText .= $value . '<br>';
}

$detailText = '';

foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
    $detailText .= '<b>' . $key . '</b>: ' . $value . '<br>';
}
?>
<div class="employees-view">

    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Roles', ['setup-roles', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Permissions', ['setup-permissions', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light']) ?>
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
                            'username',
                            'name',
                            'email',
                            'auth_key',
                            // 'password_hash',
                            'confirmation_token',
                            [
                                'label' => 'Status',
                                'value' => Employees::getStatusList()[$model->status],
                            ],
                            'registration_ip',
                            [
                                'label' => 'Bind To IP',
                                'format' => 'raw',
                                'value' => $bindText,
                            ],
                            [
                                'label' => 'Detail Info',
                                'format' => 'raw',
                                'value' => $detailText,
                            ]
                            // 'bind_to_ip',
                            // 'detail_info',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>

</div>
