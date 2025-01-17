<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\file\FileInput;

/** @var yii\web\View $this */
/** @var app\models\PaymentChannels $model */

$this->title = 'Update Image Channel: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Channels', 'url' => ['channel']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view-channel', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update Image';
?>

<div class="edc-update-category-image">

    <p>
        <?= Html::a('Back', ['view-channel', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'options' => ['enctype' => 'multipart/form-data', 'class' => 'disable-submit-buttons'],
                    ]); ?>

                    <?php if($model->image_url): ?>
                        <div class="form-group mb-3">
                            <?= Html::label('Current Image', null, ['class' => 'control-label col-md-2']) ?>
                            <?= Html::img(Yii::$app->params['domainImageChannel'].$model->image_url, ['class' => 'img-responsive']) ?>
                        </div>
                    <?php endif; ?>
                    <?= $form->field($model, 'imageFile')->widget(FileInput::classname(), [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'showUpload' => false,
                        ]
                    ])->hint('ukuran <span class="fw-bold text-danger">500 x 500 px</span>, harus svg'); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Upload Image', ['class' => 'btn btn-primary waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>