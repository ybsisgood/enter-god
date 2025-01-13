<?php 

use yii\helpers\Html;
use kartik\form\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'Change Password : ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-create">
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
                    ]) ?>

                    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <?= Html::submitButton('Change Password', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                            <?= Html::a('Back', ['view', 'id' => $model->id], ['class' => 'btn btn-primary waves-effect waves-light']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
