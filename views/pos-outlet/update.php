<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PosOutlet $model */

$this->title = 'Update Pos Outlet: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pos Outlets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pos-outlet-update">

    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
