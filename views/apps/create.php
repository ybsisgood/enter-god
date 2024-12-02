<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Apps $model */

$this->title = 'Create Apps';
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apps-create">

    <p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary waves-effect waves-light']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
