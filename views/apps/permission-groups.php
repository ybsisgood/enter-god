<?php

use app\models\PermissionGroups;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;

/** @var yii\web\View $this */
/** @var app\models\search\PermissionGroupsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Permission Groups : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['apps/view', 'seo_url' => $model->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-groups-index">

    <p>
        <?= Html::a('Back', ['apps/view', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
        <button type="button" class="btn btn-sm btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addPermissionGroupsModal">Add New Permission Groups</button>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
        <?= Html::a('List Deleted', ['list-permission-groups-deleted', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <div class="modal fade" id="addPermissionGroupsModal" tabindex="-1" aria-labelledby="addPermissionGroupsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-bg-success">
                    <h1 class="modal-title fs-5" id="addPermissionGroupsModalLabel">Add Permission Groups</h1>
                    <button type="button" class="btn-close" aria-label="Close" onclick="resetForm()"></button>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'disable-submit-buttons',
                            'id' => 'add-permission-groups-form',
                        ],
                    ]) ?>
                    <?= $form->field($newPermissionGroups, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($newPermissionGroups, 'code_permission_groups')->textInput(['maxlength' => true])->hint('Jangan pake SEPASI, gunakan camelCase') ?>

                    <?= $form->field($newPermissionGroups, 'status')->widget(SwitchInput::classname(), [
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
                'attribute' => 'app_id',
                'value' => 'apps.name',
            ],
            'name',
            'code_permission_groups',
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
                        return Html::a('<i class="fas fa-eye"></i>', ['view-permission-groups', 'id' => $model->id, 'code_permission_groups' => $model->code_permission_groups], [
                            'title' => 'View',
                            'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        if($model->code_permission_groups == 'uncommonPermission') {
                            return '';
                        }
                        return Html::a('<i class="fas fa-edit"></i>', ['update-permission-groups', 'id' => $model->id, 'code_permission_groups' => $model->code_permission_groups], [
                            'title' => 'Update',
                            'class' => 'btn btn-sm btn-success waves-effect waves-light',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        if($model->code_permission_groups == 'uncommonPermission') {
                            return '';
                        }
                        return Html::a('<i class="fas fa-trash"></i>', ['delete-permission-groups', 'id' => $model->id], [
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

<script>
    function resetForm() {
        const form = document.getElementById('add-permission-groups-form');
        form.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('addPermissionGroupsModal'));
        modal.hide();
    }
</script>
