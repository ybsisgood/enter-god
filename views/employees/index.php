<?php

use app\models\Employees;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\EmployeesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-index">

    <p>
        <?= Html::a('Create Employees', ['create'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
        <?php if(Yii::$app->user->identity->username == 'superadmin') : ?> 
            <?= Html::a('List Deleted', ['list-deleted'], ['class' => 'btn btn-danger btn-sm waves-effect waves-light']) ?>
        <?php endif; ?>
    </p>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::a('reset filter', ['index'], ['class' => 'btn btn-outline-primary btn-sm waves-effect waves-light mb-1 float-end']) ?>
                </div>
            </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    // 'id',
                    'username',
                    'name',
                    'email',
                    // 'auth_key',
                    // 'password_hash',
                    'confirmation_token',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return Employees::getStatusList()[$model->status];
                        },
                    ],
                    //'registration_ip',
                    //'bind_to_ip',
                    //'detail_info',
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{view} {update} {change-password} {delete}',
                        'width' => '200px',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->id], [
                                    'title' => 'View',
                                    'class' => 'btn btn-sm btn-primary waves-effect waves-light',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], [
                                    'title' => 'Update',
                                    'class' => 'btn btn-sm btn-success waves-effect waves-light',
                                ]);
                            },
                            'change-password' => function ($url, $model) {
                                return Html::a('<i class="fas fa-lock"></i>', ['change-password', 'id' => $model->id], [
                                    'title' => 'Change Password',
                                    'class' => 'btn btn-sm btn-warning waves-effect waves-light',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], [
                                    'title' => 'Delete',
                                    'class' => 'btn btn-sm btn-danger waves-effect waves-light',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ]
                                ]);
                            }
                        ]
                    ]
                
                ],
            ]); ?>
        </div>
    </div>

</div>
