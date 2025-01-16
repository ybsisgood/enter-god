<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var app\models\PaymentVendor $model */

$this->title = 'Update Payment Vendor : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Vendors', 'url' => ['vendor']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view-vendor', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="payment-vendor-update">
    <p>
        <?= Html::a('Back', ['view-vendor', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="payment-vendor-form">
                        <?php $form = ActiveForm::begin([
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'options' => ['enctype' => 'multipart/form-data', 'class' => 'disable-submit-buttons']
                        ]); ?>
                            
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
                                'pluginOptions' => [
                                    'size' => 'small',
                                    'onText' => 'Active',
                                    'offText' => 'Inactive',
                                ],
                            ]); ?>

                            <div class="form-group">
                                <?= Html::submitButton('Save Data', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                                <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary waves-effect waves-light']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
