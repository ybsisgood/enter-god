<?php

use app\models\PaymentCategories;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\bootstrap5\Dropdown;

/** @var yii\web\View $this */
/** @var app\models\PaymentCategories $model */

$this->title = 'Create Payment Categories';
$this->params['breadcrumbs'][] = ['label' => 'Payment Categories', 'url' => ['category']];
$this->params['breadcrumbs'][] = $this->title;
$listStatus = $model->getStatusList();
unset($listStatus[PaymentCategories::STATUS_DELETED]);

?>
<div class="payment-categories-create">

    <p>
        <?= Html::a('Back', ['category'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'disable-submit-buttons',
                        ],
                    ]) ?>
                    
                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'status')->widget(Select2::classname(), [
                            'data' => $listStatus,
                            'options' => ['placeholder' => 'Select Status ...'],
                            'pluginOptions' => [
                                'allowClear' => true
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
