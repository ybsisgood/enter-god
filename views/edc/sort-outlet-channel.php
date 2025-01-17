<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\sortinput\SortableInput;

$this->title = 'Sort Payment Channels In Outlet : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Outlets', 'url' => ['outlet']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sort-homepage">
    <p>
        <?= Html::a('Back', ['view-outlet', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="card shadow">
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'disable-submit-buttons'
                ],
            ]); ?>
                <?php
                    echo '<div class="row"><div class="col-sm-6">';
                    echo $form->field($model, 'sortChannel')->widget(
                    SortableInput::classname(),[
                        'items' => $alreadySaveChannel,
                        'hideInput' => true,
                        'sortableOptions' => [
                            'itemOptions'=>['class'=>'bg-primary text-white'],
                            'connected'=>true,
                        ],
                        'options' => ['class'=>'form-control', 'readonly'=>true]
                    ])->label(false);
                    echo '</div></div>';
                ?>
                <div class="form-group mt-1">
                    <?= Html::submitButton('Save Data', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                </div>
                <?php
                    echo '<div class="row mt-2">';
                    echo '<div class="col-sm-6">';
                    echo SortableInput::widget([
                        'name'=>'listCategory',
                        'items' => $availableChannel,
                        'hideInput' => false,
                        'sortableOptions' => [
                            'connected'=>true,
                        ],
                        'options' => ['class'=>'form-control', 'readonly'=>true]
                    ]);
                    echo '</div>';
                    
                    echo '</div>';
                ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

