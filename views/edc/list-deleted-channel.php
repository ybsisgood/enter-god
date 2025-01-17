<?php

use app\models\PaymentChannels;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\PaymentChannelsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'List Deleted Payment Channels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-channels-index">

    <p>
        <?= Html::a('List Payment Channels', ['channel'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
       
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
                        'template' => '{restore}',
                        'width' => '200px',
                        'buttons' => [
                            'restore' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash-restore"></i>', ['restore-channel', 'id' => $model->id], [
                                    'class' => 'btn btn-primary btn-sm waves-effect waves-light',
                                    'title' => 'Restore',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to restore this item?',
                                        'method' => 'post'
                                    ]
                                ]);
                            }
                        ]
                    ]
                    //'image_url:url',
                    //'sort',
                    //'detail_info',
                
                ],
            ]); ?>
        </div>
    </div>

</div>
