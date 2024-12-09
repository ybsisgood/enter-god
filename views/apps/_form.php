<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\Apps;
use kartik\datetime\DateTimePicker;

/** @var yii\web\View $this */
/** @var app\models\Apps $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="apps-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'class' => 'disable-submit-buttons',],
            'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php if($model->isNewRecord): ?>
    <?= $form->field($model, 'code_app')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'pic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => Apps::getStatusList(),
        'options' => ['placeholder' => 'Select Status ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'status_env')->widget(Select2::classname(), [
        'data' => Apps::getEnvList(),
        'options' => ['placeholder' => 'Select Environment ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?=  $form->field($model, 'live_date')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Enter Live Date ...'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?=  $form->field($model, 'whitelist_ip')->textInput(['maxlength' => true])->hint('Enter IP with comma separated. Ex: 1.1.1.1, 2.2.2.2') ?>

    <?=  $form->field($model, 'whitelist_domain')->textInput(['maxlength' => true])->hint('Enter Domain with comma separated. Ex: domain1.com, domain2.com') ?>

    <div class="form-group">
        <?= Html::submitButton('Save Data', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary waves-effect waves-light']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
