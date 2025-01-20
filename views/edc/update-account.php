<?php

use app\models\PaymentAccounts;
use Faker\Provider\ar_EG\Payment;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\markdown\MarkdownEditor;
use kartik\number\NumberControl;
use kdn\yii2\JsonEditor;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\PaymentAccounts $model */

$this->title = 'Update Payment Accounts : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Accounts', 'url' => ['account']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view-account', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

$listStatus = $model->getStatusList();
unset($listStatus[PaymentAccounts::STATUS_DELETED]);
?>
<div class="payment-accounts-create">

    <p>
        <?= Html::a('Back', ['account'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'disable-submit-buttons'
        ]
    ]); ?>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <?= $form->field($model, 'payment_vendor_id')->widget(Select2::classname(), [
                        'data' => $vendorList,
                        'options' => ['placeholder' => 'Select a vendor ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])?>

                    <?= $form->field($model, 'payment_category_id')->widget(Select2::classname(), [
                        'data' => $categoryList,
                        'options' => ['placeholder' => 'Select a category ...', 'id' => 'cat1-id'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'id' => 'payment-category-id'
                    ])?>

                    <?= $form->field($model, 'payment_channel_id')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => [
                            $model->payment_channel_id => $channelList[$model->payment_channel_id],
                        ],
                        'options' => ['id' => 'channel-id', 'placeholder' => 'Select ...'],
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['cat1-id'],
                            'url' => Url::to(['/edc/list-channel']),
                            'params' => ['input-type-1', 'input-type-2']
                        ]
                        ]);
                    ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'detail_keys')->widget(
                            JsonEditor::class,
                            [
                                'clientOptions' => ['modes' => ['code', 'tree'],'mode' => 'code'],
                                'decodedValue' => $model->isNewRecord ? [] : $model->detail_keys,
                            ]
                        );

                    ?>

                    <?= $form->field($model, 'extra_code')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status')->widget(Select2::classname(), [
                        'data' => $listStatus,
                        'options' => ['placeholder' => 'Select a status ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                    
                    <?= $form->field($model, 'how_to_payment')->widget(
                        MarkdownEditor::classname(), 
                        ['height' => 300, 'encodeLabels' => false]
                    ); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <?= $form->field($model, 'mdr_percent')->widget(NumberControl::classname(), [
                        'name' => 'mdr_percent',
                        'displayOptions' => [
                            'placeholder' => 'Mdr in %...'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'mdr_price')->widget(NumberControl::classname(), [
                        'name' => 'mdr_price',
                        'displayOptions' => [
                            'placeholder' => 'Mdr in Rp...'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'min_payment')->widget(NumberControl::classname(), [
                        'name' => 'min_payment',
                        'displayOptions' => [
                            'placeholder' => 'Min Payment in Rp...'
                        ]
                    ]); ?>


                    <?= $form->field($model, 'max_payment')->widget(NumberControl::classname(), [
                        'name' => 'max_payment',
                        'displayOptions' => [
                            'placeholder' => 'Max Payment in Rp...'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'free_mdr_min')->widget(NumberControl::classname(), [
                        'name' => 'free_mdr_min',
                        'displayOptions' => [
                            'placeholder' => 'Free Mdr min payment at...'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'free_mdr_max')->widget(NumberControl::classname(), [
                        'name' => 'free_mdr_max',
                        'displayOptions' => [
                            'placeholder' => 'Free Mdr max payment at...'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'limit_days')->widget(NumberControl::classname(), [
                        'name' => 'limit_days',
                        'displayOptions' => [
                            'placeholder' => 'Limit days...'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'limit_month')->widget(NumberControl::classname(), [
                        'name' => 'limit_month',
                        'displayOptions' => [
                            'placeholder' => 'Limit month...'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'limit_year')->widget(NumberControl::classname(), [
                        'name' => 'limit_year',
                        'displayOptions' => [
                            'placeholder' => 'Limit year...'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'secret_code')->textInput(['maxlength' => true]) ?>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <?= Html::submitButton('Save Data', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary waves-effect waves-light']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
