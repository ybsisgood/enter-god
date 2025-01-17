<?php

use app\models\PaymentChannels;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PaymentChannelsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Payment Channels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-channels-index">

    <p>
        <?= Html::a('Create Payment Channels', ['create-channel'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?= Html::a('Sort Payment Channels', ['sort-channel'], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
            <?= Html::a('List Deleted Payment Channels', ['list-deleted-channel'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= Html::a('Reset Filter', ['channel'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1 float-end']) ?>
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
                    [
                        'attribute' => 'categoryName',
                        'value' => function ($model) {
                            return $model->detail_info['category']['name'] ?? 'no set';
                        }
                    ],
                    'name',
                    'code',
                    [
                        'attribute' => 'sort',
                        'hAlign' => 'center',
                    ],
                    [
                        'attribute' => 'image_url',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->image_url) {
                                return Html::img(Yii::$app->params['domainImageChannel'].$model->image_url, ['width' => '100px']);
                            }
                            else {
                                return Html::img(Yii::$app->params['imagePlaceholderChannel'], ['width' => '100px']);
                            }
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => PaymentChannels::getStatusList(),
                        'value' => function ($model) {
                            return PaymentChannels::getStatusList()[$model->status];
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{view} {update} {update-image} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fa fa-eye"></span>', ['view-channel', 'id' => $model->id], [
                                    'title' => 'View',
                                    'class' => 'btn btn-primary btn-sm',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil-alt"></span>', ['update-channel', 'id' => $model->id], [
                                    'title' => 'Update',
                                    'class' => 'btn btn-success btn-sm',
                                ]);
                            },
                            'update-image' => function ($url, $model) {
                                return Html::a('<span class="fa fa-image"></span>', ['update-image-channel', 'id' => $model->id], [
                                    'title' => 'Update Image',
                                    'class' => 'btn btn-warning btn-sm',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span>', ['delete-channel', 'id' => $model->id], [
                                    'title' => 'Delete',
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post'
                                    ],
                                ]);
                            },
                        ],
                    ]
                ],
            ]); ?>
        </div>
    </div>

</div>
