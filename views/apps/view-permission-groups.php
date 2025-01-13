<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Apps;
use app\models\PermissionGroups;
use app\models\Permissions;

/** @var yii\web\View $this */
/** @var app\models\Apps $model */

$this->title = '[ ' .$apps->name . '] Permission Groups : ' . $permissionGroups->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$text = '';
foreach ($permissionGroups->detail_info['change_log'] ?? [] as $key => $value) {
    $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
}
?>
<div class="apps-view">

    <p>
        <?= Html::a('Back', ['apps/permission-groups', 'seo_url' => $apps->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
        <?php if($permissionGroups->code_permission_groups != 'uncommonPermission') : ?>
        <?= Html::a('Update', ['update-permission-groups', 'id' => $permissionGroups->id, 'code_permission_groups' => $permissionGroups->code_permission_groups], ['class' => 'btn btn-sm btn-success waves-effect waves-light']) ?>
        <?= Html::a('Delete', ['delete-permission-groups', 'id' => $permissionGroups->id], [
            'class' => 'btn btn-sm btn-danger waves-effect waves-light',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
    </p>
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                <?= DetailView::widget([
                    'model' => $permissionGroups,
                    'attributes' => [
                        'id',
                        [
                            'label' => 'Apps',
                            'value' => $apps->name
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'name',
                                    'format' => 'raw',
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ],
                                [
                                    'attribute' => 'code_permission_groups',
                                    'format' => 'raw',
                                    'valueColOptions'=>['style'=>'width:30%'], 
                                ]
                            ]
                        ],
                        [
                            'attribute' => 'status',
                            'value' => PermissionGroups::getStatusList()[$permissionGroups->status],
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
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <span class="fw-bold">List Permission</span>
                    <hr>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($getPermissionList as $key => $value) : ?>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="mb-0"><?=$value['name']?></span>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <?php if($value['status'] == 1) : ?>
                                            <span class="badge badge-soft-success"><?= Permissions::getStatusList()[$value['status']]?></span>
                                        <?php else : ?>
                                            <span class="badge badge-soft-danger"><?= Permissions::getStatusList()[$value['status']]?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
