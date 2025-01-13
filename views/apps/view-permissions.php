<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Apps;
use app\models\PermissionGroups;
use app\models\Permissions;

/** @var yii\web\View $this */
/** @var app\models\Apps $model */

$this->title = '[ ' .$apps->name . '] Permissions : ' . $permissions->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
foreach ($permissions->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
}
?>
<div class="apps-view">

    <p>
        <?= Html::a('Back', ['apps/permissions', 'seo_url' => $apps->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
        <?= Html::a('Update', ['update-permissions', 'id' => $permissions->id, 'code_permissions' => $permissions->code_permissions], ['class' => 'btn btn-sm btn-success waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete-permissions', 'id' => $permissions->id], [
            'class' => 'btn btn-sm btn-danger waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                <?= DetailView::widget([
                    'model' => $permissions,
                    'attributes' => [
                        'id',
                        [
                            'columns' => [
                                [
                                    'attribute' => 'app_id',
                                    'label' => 'App',
                                    'value' => $permissions->apps->name,
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ],
                                [
                                    'attribute' => 'permission_group_id',
                                    'label' => 'Permission Group',
                                    'value' => $permissions->permissionGroups->name,    
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ]
                            ]
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'name',
                                    'format' => 'raw',
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ],
                                [
                                    'attribute' => 'code_permissions',
                                    'format' => 'raw',
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ]
                            ]
                        ],   
                        [
                            'attribute' => 'status',
                            'value' => Permissions::getStatusList()[$permissions->status],
                        ],
                        [
                            'label' => 'Change Log',
                            'format' => 'raw',
                            'value' => $text
                        ]
                    ],
                ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
