<?php

use app\models\PosTableLayout;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\PosTableLayout $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pos-table-layout-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'pos-table-layout-form',
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'options' => ['enctype' => 'multipart/form-data', 'class' => 'disable-submit-buttons'],
                    ]); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'layout_x')->textInput() ?>

                    <?= $form->field($model, 'layout_y')->textInput() ?>

                    <?= $form->field($model, 'layout_size_x')->textInput() ?>

                    <?= $form->field($model, 'layout_size_y')->textInput() ?>

                    <?= $form->field($model, 'layout')->textInput() ?>

                    <?= $form->field($model, 'layout_shape')->widget(Select2::className(), [
                        'data' => PosTableLayout::getShapeList(),
                        'options' => ['placeholder' => 'Select Shape ...', 'multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>

                    <?= $form->field($model, 'status')->widget(Select2::className(), [
                        'data' => [PosTableLayout::STATUS_INACTIVE => 'Inactive', PosTableLayout::STATUS_ACTIVE => 'Active'],
                        'options' => ['placeholder' => 'Select Status ...', 'multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success waves-effect waves-light']) ?>
                        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary waves-effect waves-light']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
