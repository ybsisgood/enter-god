<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PosUser $model */

$this->title = 'Create Pos User';
$this->params['breadcrumbs'][] = ['label' => 'Pos Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pos-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
