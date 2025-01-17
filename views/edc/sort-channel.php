<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\sortinput\SortableInput;

/** @var yii\web\View $this */
/** @var app\models\PaymentChannels $model */

$this->title = 'Sort Payment Channels';
$this->params['breadcrumbs'][] = ['label' => 'Payment Channels', 'url' => ['channel']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="payment-categories-index">

    <p>
        <?= Html::a('Back', ['channel'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="card shadow col-md-6">
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'disable-submit-buttons'
                ],
            ]); ?>

            <?= $form->field($formList, 'sortChannels')->widget(
                SortableInput::className(),
                [
                    'items' => $arrayList,
                ]
            ); ?>

            <div class="form-group">
                <?= Html::submitButton('Save Data', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
