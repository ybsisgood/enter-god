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

$this->title = 'List Roles Deleted: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['apps/view', 'seo_url' => $model->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="roles-index">

    <p>
        <?= Html::a('List Roles', ['apps/roles', 'seo_url' => $model->seo_url], ['class' => 'btn btn-sm btn-primary waves-effect waves-light']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'attribute' => 'app_id',
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
                        return Html::a('<i class="fas fa-trash-restore"></i>', ['restore-roles', 'id' => $model->id], [
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
            //'permission_json',
        ],
    ]); ?>


</div>
