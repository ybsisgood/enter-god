<?php

use app\models\Outlets;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Outlets $model */

$this->title = 'Create Outlets';
$this->params['breadcrumbs'][] = ['label' => 'Outlets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$listStatus = Outlets::getStatusList();
unset($listStatus[Outlets::STATUS_DELETED]);
?>
<div class="outlets-create">

    <p>
        <?= Html::a('Back', ['outlet'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="outlets-create">
                        <?php $form = ActiveForm::begin([
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'options' => [
                                'enctype' => 'multipart/form-data',
                                'class' => 'disable-submit-buttons'
                            ]
                        ]); ?>

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'address')->textInput(['maxlength' => true])->hint('Pakai | untuk pemisah line alamat, perbaris maksimal 25') ?>

                        <?= $form->field($model, 'status')->widget(Select2::classname(), [
                            'data' => $listStatus,
                            'options' => ['placeholder' => 'Select Status ...'],
                        ]) ?>

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

</div>
