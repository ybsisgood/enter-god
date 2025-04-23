<?php

use app\models\PosOutlet;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\markdown\MarkdownEditor;

/** @var yii\web\View $this */
/** @var app\models\PosOutlet $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pos-outlet-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'disable-submit-buttons'],
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->widget(MarkdownEditor::classname(), [
        'height' => 300,
        'encodeLabels' => false,
        'options' => ['placeholder' => 'Write your address here...'],
        'pluginOptions' => [
            'enableSplitMode' => true,
            'enableLivePreview' => true,
            'showExport' => false,
        ]
    ]) ?>

    <?= $form->field($model, 'location_lat')->textInput() ?>

    <?= $form->field($model, 'location_lng')->textInput() ?>

    <?= $form->field($model, 'hwid_server')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => PosOutlet::getStatusList(),
        'options' => ['placeholder' => 'Select Status ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'ip_whitelist')->widget(Select2::classname(), [
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
