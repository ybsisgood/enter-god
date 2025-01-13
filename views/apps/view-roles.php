<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Apps;
use app\models\Roles;
use app\models\Permissions;

/** @var yii\web\View $this */
/** @var app\models\Apps $model */

$this->title = '[' .$apps->name . '] Roles : ' . $roles->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $apps->name, 'url' => ['view', 'seo_url' => $apps->seo_url]];
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['roles', 'seo_url' => $apps->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
foreach ($roles->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
}
?>
<div class="apps-view">

    <p>
        <?= Html::a('Back', ['roles', 'seo_url' => $apps->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
        <?php if($roles->code_roles != 'superadmin' && $roles->code_roles != 'admin') : ?>
        <?= Html::a('Update', ['update-roles', 'id' => $roles->id, 'code_roles' => $roles->code_roles], ['class' => 'btn btn-sm btn-success waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete-roles', 'id' => $roles->id], [
            'class' => 'btn btn-sm btn-danger waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
    </p>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                <?= DetailView::widget([
                    'model' => $roles,
                    'attributes' => [
                        'id',
                        [
                            'columns' => [
                                [
                                    'attribute' => 'name',
                                    'format' => 'raw',
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ],
                                [
                                    'attribute' => 'code_roles',
                                    'format' => 'raw',
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ]
                            ]
                        ],
                        [
                            'attribute' => 'status',
                            'value' => Roles::getStatusList()[$roles->status],
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
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <span class="fw-bold">List Permission :</span>
                    <ul class="list-group mt-2">
                        <?php 
                        // Mengelompokkan permissionsDetail berdasarkan name_pemission_groups
                        $groupedPermissions = [];
                        $permissionList = $roles->permission_json['permissionsDetail'] ?? [];
                        foreach ($permissionList as $permission) {
                            $groupedPermissions[$permission['name_pemission_groups']][] = $permission;
                        }

                        // Menampilkan permissions berdasarkan pengelompokan
                        foreach ($groupedPermissions as $groupName => $permissions) : ?>
                            <li class="list-group-item fw-bold bg-light"><?= htmlspecialchars($groupName) ?></li>
                            <?php foreach ($permissions as $permission) : ?>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <span class="mb-0"><?= htmlspecialchars($permission['name']) ?></span>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <?php if(isset($permission['status']) && $permission['status'] == 1) : ?>
                                                <span class="badge badge-soft-success"><?= htmlspecialchars(Permissions::getStatusList()[$permission['status']]) ?></span>
                                            <?php elseif(isset($permission['status'])) : ?>
                                                <span class="badge badge-soft-danger"><?= htmlspecialchars(Permissions::getStatusList()[$permission['status']]) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
