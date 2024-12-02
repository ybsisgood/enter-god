<?php

use app\models\Apps;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\AppsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Apps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apps-index">
    <p>
        <?= Html::a('Create Apps', ['create'], ['class' => 'btn btn-success waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'responsiveWrap' => false,
                        'options' => [
                            'class' => 'align-items-middle'
                        ],
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn'],

                            // 'id',
                            'name',
                            'description:ntext',
                            'code_app',
                            'status',
                            //'status_env',
                            //'pic',
                            //'live_date',
                            //'detail_info',
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                                            'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                            'title' => 'View',
                                        ]);
                                    }
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    
</div>
