<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PosSession $model */

$this->title = 'Update Pos Session: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pos Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pos-session-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
