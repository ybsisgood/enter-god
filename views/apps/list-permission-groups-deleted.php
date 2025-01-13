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

$this->title = 'List Permission Groups Deleted : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['apps/view', 'seo_url' => $model->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-groups-index">

    <p>
        <?= Html::a('List Permission Groups', ['apps/permission-groups', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
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
                    'name',
                    'code_permission_groups',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return $model->getStatusList()[$model->status];
                        },
                    ],
                    [
                        'label' => 'Detail Info',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $text = '';
                            foreach ($model->detail_info['change_log'] ?? [] as $key => $value) {
                                $text .= '<b>' . $key . '</b>: ' . $value . '<br>'; 
                            }
                            return $text;
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{restore}',
                        'width' => '200px',
                        'buttons' => [
                            'restore' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash-restore"></i>', ['restore-permission-groups', 'id' => $model->id], [
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
