<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var app\models\Roles $updateRole */

$this->title = '[' . $updateRole->apps->name . '] Update Role : ' . $updateRole->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $updateRole->apps->name, 'url' => ['apps/view', 'seo_url' => $updateRole->apps->seo_url]];
$this->params['breadcrumbs'][] = ['label' => $updateRole->name, 'url' => ['apps/view-roles', 'id' => $updateRole->id, 'code_roles' => $updateRole->code_roles]];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('Back', ['apps/view-roles', 'id' => $updateRole->id, 'code_roles' => $updateRole->code_roles], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
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

                    <?= $form->errorSummary($updateRole) ?>

                    <?= $form->field($updateRole, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($updateRole, 'code_roles')->textInput(['maxlength' => true])->hint('Jangan pake SEPASI, gunakan camelCase') ?>

                    <?= $form->field($updateRole, 'status')->widget(SwitchInput::classname(), [
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
