<?php

use app\models\Permissions;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;


/** @var yii\web\View $this */
/** @var app\models\search\PermissionsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Permissions : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['apps/view', 'seo_url' => $model->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <p>
        <?= Html::a('Back', ['apps/view', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
        <button type="button" class="btn btn-sm btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addPermissionsModal">Add New Permissions</button>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
        <?= Html::a('List Deleted', ['list-permissions-deleted', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <div class="modal fade" id="addPermissionsModal" tabindex="-1" aria-labelledby="addPermissionsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-bg-success">
                    <h1 class="modal-title fs-5" id="addPermissionsModalLabel">Add Permissions</h1>
                    <button type="button" class="btn-close" aria-label="Close" onclick="resetForm()"></button>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'disable-submit-buttons',
                            'id' => 'add-permissions-form',
                        ],
                    ]) ?>

                    <?= $form->field($newPermissions, 'permission_group_id')->widget(Select2::classname(), [
                        'data' => $listPermissionGroups,
                        'options' => [
                            'placeholder' => 'Select Permission Groups',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false
                        ]
                    ]); ?>
                    
                    <?= $form->field($newPermissions, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($newPermissions, 'code_permissions')->textInput(['maxlength' => true])->hint('Jangan pake SEPASI, gunakan camelCase') ?>

                    <?= $form->field($newPermissions, 'status')->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'size' => 'small',
                            'onText' => 'Active',
                            'offText' => 'Inactive',
                        ],
                    ]); ?>
                    <?= Html::submitButton('Save Data', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary waves-effect waves-light']) ?>
                </div>
                <?php ActiveForm::end(); ?> 
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsiveWrap' => false,
                'options' => [
                    'id' => 'align-items-middle'
                ],
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],

                    // 'id',
                    [
                        'attribute' => 'appName',
                        'value' => 'apps.name',
                    ],
                    [
                        'attribute' => 'permissionGroupName',
                        'value' => 'permissionGroups.name',
                    ],
                    'name',
                    'code_permissions',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return $model->getStatusList()[$model->status];
                        },
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', ['view-permissions', 'id' => $model->id, 'code_permissions' => $model->code_permissions], [
                                    'title' => 'View',
                                    'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-edit"></i>', ['update-permissions', 'id' => $model->id, 'code_permissions' => $model->code_permissions], [
                                    'title' => 'Update',
                                    'class' => 'btn btn-sm btn-success waves-effect waves-light',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', ['delete-permissions', 'id' => $model->id], [
                                    'title' => 'Delete',
                                    'class' => 'btn btn-sm btn-danger waves-effect waves-light',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ]
                    ],
                    //'detail_info',
                
                ],
            ]); ?>
        </div>
    </div>

</div>

<script>
    function resetForm() {
        const form = document.getElementById('add-permissions-form');
        form.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('addPermissionsModal'));
        modal.hide();
    }
</script>
