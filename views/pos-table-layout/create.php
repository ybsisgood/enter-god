<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PosTableLayout $model */

$this->title = 'Create Table Layout (' . $outlet->name . ')';
$this->params['breadcrumbs'][] = ['label' => 'Pos Outlets', 'url' => ['pos-outlet/index']];
$this->params['breadcrumbs'][] = ['label' => $outlet->name, 'url' => ['pos-outlet/view', 'id' => $outlet->id, 'slug_url' => $outlet->slug_url]];
$this->params['breadcrumbs'][] = ['label' => 'Table Layouts', 'url' => ['index', 'outletID' => $outlet->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pos-table-layout-create">

    <p>
        <?= Html::a('Back', ['index', 'outletID' => $outlet->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
