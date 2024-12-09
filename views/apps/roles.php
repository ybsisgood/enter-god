<?php

use app\models\Roles;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\form\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\RolesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Roles : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['apps/view', 'seo_url' => $model->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .align-items-middle {
        vertical-align: middle !important;
    }
</style>
<div class="roles-index">

    <p>
        <?= Html::a('Back', ['apps/view', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
        <button type="button" class="btn btn-sm btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add New Role</button>
    </p>

    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addRoleModalLabel">Add Role</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'disable-submit-buttons',
                        ],
                    ]) ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="code_roles" class="form-label">Code Roles</label>
                                <input type="text" class="form-control" id="code_roles" name="code_roles">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Save Data', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait'], 'data-bs-dismiss' => 'modal']) ?>
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary waves-effect waves-light']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'app_id',
                'value' => 'apps.name',
            ],
            'name',
            'code_roles',
            'status',
            //'detail_info',
            //'permission_json',
        ],
    ]); ?>


</div>