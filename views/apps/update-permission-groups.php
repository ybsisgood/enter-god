<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var app\models\Roles $updateRole */

$this->title = 'Update Permission Groups : ' . $permissionGroups->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $permissionGroups->name, 'url' => ['apps/view-permission-groups', 'id' => $permissionGroups->id, 'code_permission_groups' => $permissionGroups->code_permission_groups]];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('Back', ['apps/view-permission-groups', 'id' => $permissionGroups->id, 'code_permission_groups' => $permissionGroups->code_permission_groups], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
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

                    <?= $form->errorSummary($permissionGroups) ?>

                    <?= $form->field($permissionGroups, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($permissionGroups, 'code_permission_groups')->textInput(['maxlength' => true])->hint('Jangan pake SEPASI, gunakan camelCase') ?>

                    <?= $form->field($permissionGroups, 'status')->widget(SwitchInput::classname(), [
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
