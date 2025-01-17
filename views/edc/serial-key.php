<?php

use app\models\SerialKeys;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\SerialKeysSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Serial Keys';
$this->params['breadcrumbs'][] = $this->title;
$listStatus = SerialKeys::getStatusList();
unset($listStatus[SerialKeys::STATUS_DELETED]);
?>
<div class="serial-keys-index">
    
    <p>
        <?= Html::a('Create Serial Keys', ['create-serial-key'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?>
        <?= Html::a('List Deleted', ['list-deleted-serial-key'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= Html::a('Reset Filter', ['serial-key'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light float-end mb-1']) ?>
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
                    'activation_code',
                    [
                        'attribute' => 'outlet_id',
                        'filter' => $searchModel->getOutletList(),
                        'value' => function ($model) {
                            return $model->outlet->name;
                        }
                    ],
                    'local_code',
                    [
                        'attribute' => 'status',
                        'filter' => $listStatus,
                        'value' => function ($model) {
                            return SerialKeys::getStatusList()[$model->status];
                        }
                    ],
                    //'detail_info',
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{view} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fa fa-eye"></i>', ['view-serial-key', 'id' => $model->id], ['class' => 'btn btn-sm btn-info']);
                            },
                            'delete' => function ($url, $model) {
                                if(Yii::$app->user->identity->username == 'superadmin') {
                                    return Html::a('<i class="fa fa-trash"></i>', ['delete-serial-key', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                }
                            }
                        ]
                    ],
                    
                ],
            ]); ?>
        </div>
    </div>

</div>
