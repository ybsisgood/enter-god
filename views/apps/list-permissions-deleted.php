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

$this->title = 'List Permissions Deleted : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['apps/view', 'seo_url' => $model->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <p>
        <?= Html::a('List Permissions', ['apps/permissions', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
    </p>

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
                        'attribute' => 'app_id',
                        'value' => 'apps.name',
                    ],
                    [
                        'attribute' => 'permission_group_id',
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
                        'template' => '{restore}',
                        'width' => '200px',
                        'buttons' => [
                            'restore' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash-restore"></i>', ['restore-permissions', 'id' => $model->id], [
                                    'title' => 'Restore',
                                    'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to restore this item?',
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
