<?php

use app\models\PaymentCategories;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PaymentCategoriesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Payment Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-categories-index">

    <p>
        <?= Html::a('Create Payment Categories', ['create-category'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Sort Categories', ['sort-category'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
            <?= Html::a('List Deleted', ['list-deleted-category'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::a('reset filter', ['category'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1 float-end']) ?>
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
                        'template' => '{view} {update} {update-image} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', ['view-category', 'id' => $model->id], [
                                    'title' => 'View',
                                    'class' => 'btn btn-sm btn-info waves-effect waves-light',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-edit"></i>', ['update-category', 'id' => $model->id], [
                                    'title' => 'Update',
                                    'class' => 'btn btn-sm btn-success waves-effect waves-light',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash-alt"></i>', ['delete-category', 'id' => $model->id], [
                                    'title' => 'Delete',
                                    'class' => 'btn btn-sm btn-danger waves-effect waves-light',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                            'update-image' => function ($url, $model) {
                                return Html::a('<i class="fas fa-image"></i>', ['update-image-category', 'id' => $model->id], [
                                    'title' => 'Update Image',
                                    'class' => 'btn btn-sm btn-warning waves-effect waves-light',
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
