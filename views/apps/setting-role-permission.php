<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

$this->title = 'Setting Role Permissions : ' . $role->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['apps/index']];
$this->params['breadcrumbs'][] = ['label' => $role->apps->name, 'url' => ['apps/view', 'seo_url' => $role->apps->seo_url]];
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['apps/roles', 'seo_url' => $role->apps->seo_url]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <p>
                    <?= Html::a('Back', ['apps/roles', 'seo_url' => $role->apps->seo_url], ['class' => 'btn btn-primary btn-sm waves-effect waves-light']) ?>
                </p>
                <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'disable-submit-buttons',
                            'id' => 'add-role-permission-form',
                        ],
                        'type' => ActiveForm::TYPE_HORIZONTAL
                ]) ?>
                <?php foreach($listPermissonGroups as $pg): ?>
                    <ul class="list-group">
                        <li class="list-group-item bg-light">
                            <b><?= $pg->name ?></b>
                        </li>
                        <?php foreach($listPermissions as $p): ?>
                            <?php if($p->permission_group_id == $pg->id): ?>
                                <li class="list-group-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="<?= $p->id ?>" id="permission-<?= $p->id ?>" name="permission[]" <?= in_array($p->id, $getPermissionNow) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="permission-<?= $p->id ?>"><?= $p->name ?></label>
                                    </div>
                                </li>
                                <?php $listPermissions = array_udiff($listPermissions, [$p], function($a, $b) {
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
</div>