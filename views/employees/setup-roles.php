<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

$this->title = 'Setup Roles : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['employees/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['employees/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="employees-setup-roles">
    <p>
        <?= Html::a('Back', ['employees/view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
    </p>

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
                    <?php foreach($listRoles as $role): ?>
                        <?php if($role->app_id == $app->id): ?>
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $role->id ?>" id="role-<?= $role->id ?>" name="role[]" <?= in_array($role->id, $getRoleNow) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="role-<?= $role->id ?>"><?= $role->name ?></label>
                                </div>
                            </li>
                            <?php $listRoles = array_udiff($listRoles, [$role], function($a, $b) {
                                return $a->id <=> $b->id;
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