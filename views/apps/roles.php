<?php

use app\models\Roles;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var app\models\search\RolesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Roles : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['apps/view', 'seo_url' => $model->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="roles-index">

    <p>
        <?= Html::a('Back', ['apps/view', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
        <button type="button" class="btn btn-sm btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add New Role</button>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
        <?= Html::a('List Deleted', ['list-roles-deleted', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-bg-success">
                    <h1 class="modal-title fs-5" id="addRoleModalLabel">Add Role</h1>
                    <button type="button" class="btn-close" aria-label="Close" onclick="resetForm()"></button>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'disable-submit-buttons',
                            'id' => 'add-role-form',
                        ],
                    ]) ?>
                    <?= $form->field($newRole, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($newRole, 'code_roles')->textInput(['maxlength' => true])->hint('Jangan pake SEPASI, gunakan camelCase') ?>

                    <?= $form->field($newRole, 'status')->widget(SwitchInput::classname(), [
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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-end">
                    <?= Html::a('reset filter', ['roles', 'seo_url' => $model->seo_url], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light']) ?>
                </div>
            </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsiveWrap' => false,
                'options' => [
                    'id' => 'align-items-middle'
                ],
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                        'attribute' => 'appName',
                        'value' => 'apps.name',
                    ],
                    'name',
                    'code_roles',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return Roles::getStatusList()[$model->status];
                        },
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{view} {update} {permissions} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', ['view-roles', 'id' => $model->id, 'code_roles' => $model->code_roles], [
                                    'title' => 'View',
                                    'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                if($model->code_roles == 'superadmin' || $model->code_roles == 'admin') {
                                    return '';
                                }
                                return Html::a('<i class="fas fa-edit"></i>', ['update-roles', 'id' => $model->id, 'code_roles' => $model->code_roles], [
                                    'title' => 'Update',
                                    'class' => 'btn btn-sm btn-success waves-effect waves-light',
                                ]);
                            },
                            'permissions' => function ($url, $model) {
                                if($model->code_roles == 'superadmin' || $model->code_roles == 'admin') {
                                    return '';
                                } 
                                return Html::a('<i class="fas fa-key"></i>', ['setting-role-permission', 'id' => $model->id, 'code_roles' => $model->code_roles], [
                                    'title' => 'Permissions',
                                    'class' => 'btn btn-sm btn-info waves-effect waves-light',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if($model->code_roles == 'superadmin' || $model->code_roles == 'admin') {
                                    return '';
                                }
                                return Html::a('<i class="fas fa-trash"></i>', ['delete-roles', 'id' => $model->id], [
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
                    //'permission_json',
                ],
            ]); ?>
        </div>
    </div>

</div>

<script>
    function resetForm() {
        const form = document.getElementById('add-role-form');
        form.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('addRoleModal'));
        modal.hide();
    }
</script>