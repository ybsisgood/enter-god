<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Roles $updateRole */

$this->title = 'Update Permissions : ' . $permissions->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $permissions->name, 'url' => ['apps/view-permissions', 'id' => $permissions->id, 'code_permissions' => $permissions->code_permissions]];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('Back', ['apps/view-permissions', 'id' => $permissions->id, 'code_permissions' => $permissions->code_permissions], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
</p>

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'disable-submit-buttons',
                            'id' => 'add-role-form',
                        ],
                        'type' => ActiveForm::TYPE_HORIZONTAL
                    ]) ?>

                    <?= $form->errorSummary($permissions) ?>

                    <?= $form->field($permissions, 'permission_group_id')->widget(Select2::classname(), [
                        'data' => $listPermissionGroups,
                        'options' => [
                            'placeholder' => 'Select Permission Groups',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false
                        ]
                    ]); ?>

                    <?= $form->field($permissions, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($permissions, 'code_permissions')->textInput(['maxlength' => true])->hint('Jangan pake SEPASI, gunakan camelCase') ?>

                    <?= $form->field($permissions, 'status')->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'size' => 'small',
                            'onText' => 'Active',
                            'offText' => 'Inactive',
                        ],
                    ]); ?>
                    <?= Html::submitButton('Save Data', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary waves-effect waves-light']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
