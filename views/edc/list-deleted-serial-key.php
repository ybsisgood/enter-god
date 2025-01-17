<?php

use app\models\SerialKeys;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\SerialKeysSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'List Deleted Serial Keys';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serial-keys-index">
    
    <p>
        <?= Html::a('List Serial Keys', ['serial-key'], ['class' => 'btn btn-success btn-sm waves-effect waves-light']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                    'activation_code',
                    [
                        'attribute' => 'outlet_id',
                        'value' => function ($model) {
                            return $model->outlet->name;
                        }
                    ],
                    'local_code',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return SerialKeys::getStatusList()[$model->status];
                        }
                    ],
                    //'detail_info',
                    
                ],
            ]); ?>
        </div>
    </div>

</div>
