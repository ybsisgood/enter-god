<?php

use app\models\Employees;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Employees $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="employees-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'disable-submit-buttons'],
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>

    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => Employees::getStatusList(),
        'options' => ['placeholder' => 'Select Status ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'bind_to_ip')->widget(Select2::classname(), [
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Bind IP ...', 'multiple' => true, 'tags' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [','],
            ],
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save Data', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
