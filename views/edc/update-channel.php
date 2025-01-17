<?php

use app\models\PaymentChannels;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\PaymentChannels $model */

$this->title = 'Update Payment Channels : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Channels', 'url' => ['channel']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view-channel', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

$getList = $model->getStatusList();
unset($getList[PaymentChannels::STATUS_DELETED]);
?>
<div class="payment-channels-create">

    <p>
        <?= Html::a('Back', ['view-channel', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="payment-channels-form">
                        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'options' => ['enctype' => 'multipart/form-data', 'class' => 'disable-submit-buttons']]); ?>

                            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'code')->textInput() ?>

                            <?= $form->field($model, 'payment_category_id')->widget(Select2::classname(), [
                                'data' => $listPC,
                                'options' => ['placeholder' => 'Select Category'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'multiple' => false,
                                ],
                            ]); ?>

                            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                                'data' => $getList,
                                'options' => ['placeholder' => 'Select Status'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'multiple' => false,
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

