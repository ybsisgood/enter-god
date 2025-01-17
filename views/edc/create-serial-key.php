<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\SerialKeys $model */

$this->title = 'Create Serial Keys';
$this->params['breadcrumbs'][] = ['label' => 'Serial Keys', 'url' => ['serial-key']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-keys-create">

    <p>
        <?= Html::a('Back', ['serial-key'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                            'options' => [
                                'enctype' => 'multipart/form-data',
                                'class' => 'disable-submit-buttons',
                            ],
                            'type' => ActiveForm::TYPE_HORIZONTAL
                    ]); ?>

                    <?= $form->field($model, 'outlet_id')->widget(Select2::classname(), [
                        'data' => $availableOutlet,
                        'options' => ['placeholder' => 'Select Outlet ...'],
                    ]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'activation_code')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save Data', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary waves-effect waves-light']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
