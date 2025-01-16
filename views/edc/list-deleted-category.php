<?php

use app\models\PaymentCategories;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PaymentCategoriesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'List Deleted Payment Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-categories-index">

    <p>
        <?= Html::a('Back', ['category'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= Html::a('Reset Filter', ['list-deleted-category'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1 float-end']) ?>
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
                    'name',
                    [
                        'attribute' => 'sort',
                        'hAlign' => GridView::ALIGN_CENTER
                    ],
                    // 'image_url:url',
                    [
                        'attribute' => 'image_url',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->image_url) {
                                return Html::img(Yii::$app->params['domainImageCategory'].$model->image_url, ['width' => '100px']);
                            }
                            else {
                                return Html::img(Yii::$app->params['imagePlaceholderCategory'], ['width' => '100px']);
                            }
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => PaymentCategories::getStatusList(),
                        'value' => function ($model) {
                            return PaymentCategories::getStatusList()[$model->status];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{restore}',
                        'width' => '200px',
                        'buttons' => [
                            'restore' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash-restore"></i>', ['restore-category', 'id' => $model->id], [
                                    'class' => 'btn btn-primary btn-sm waves-effect waves-light',
                                    'title' => 'Restore',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to restore this item?',
                                        'method' => 'post'
                                    ]
                                ]);
                            }
                        ]
                    ],
                    //'detail_info',
                    
                ],
            ]); ?>
        </div>
    </div>

</div>
