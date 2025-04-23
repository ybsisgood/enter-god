<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PosOutlet $model */

$this->title = 'Create Pos Outlet';
$this->params['breadcrumbs'][] = ['label' => 'Pos Outlets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pos-outlet-create">
    
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
