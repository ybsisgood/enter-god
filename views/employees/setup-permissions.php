<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

$this->title = 'Setup Permissions : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['employees/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['employees/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="employees-setup-permissions">
    <p>
        <?= Html::a('Back', ['employees/view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                            'options' => [
                                'enctype' => 'multipart/form-data',
                                'class' => 'disable-submit-buttons',
                                'id' => 'add-role-permission-form',
                            ],
                            'type' => ActiveForm::TYPE_HORIZONTAL
                    ]) ?>
                    <?php foreach($listApps as $app): ?>
                        <ul class="list-group">
                            <li class="list-group-item bg-light">
                                <b><?= $app->name ?></b>
                            </li>
                            <?php foreach($listPermissions as $permission): ?>
                                <?php if($permission->app_id == $app->id): ?>
                                    <li class="list-group-item">
                                        <div class="custom-control custom-checkbox">
                                            <?php if(in_array($permission->id, $getPermissionNow)): ?>
                                                <input class="custom-control-input" type="checkbox" value="<?= $permission->id ?>" id="permission-<?= $permission->id ?>" name="permission[]" checked disabled>
                                                <input type="hidden" name="permission[]" value="<?= $permission->id ?>">
                                            <?php else: ?>
                                                <input class="custom-control-input" type="checkbox" value="<?= $permission->id ?>" id="permission-<?= $permission->id ?>" name="permission[]">
                                            <?php endif; ?>
                                            <label class="custom-control-label" for="permission-<?= $permission->id ?>"><?= $permission->name ?></label>
                                        </div>
                                    </li>
                                    <?php $getPermissionNow = array_udiff($getPermissionNow, [$permission->id], function($a, $b) {
                                        return $a <=> $b;
                                    }); ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                    <div class="form-group mt-3">
                        <?= Html::submitButton('Save Data', ['class' => 'btn btn-success waves-effect waves-light', 'data' => ['disabled-text' => 'Please Wait']]) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

