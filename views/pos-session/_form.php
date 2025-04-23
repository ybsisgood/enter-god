<?php

use app\models\PosSession;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\PosSession $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pos-session-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'disable-submit-buttons'],
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => PosSession::getStatusList(),
        'options' => ['placeholder' => 'Select Status ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
