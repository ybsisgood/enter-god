<?php

namespace app\controllers;

use Yii;
use app\models\Apps;
use app\models\search\AppsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalFunction;
use app\models\Roles;
use app\models\search\PermissionGroupsSearch;
use app\models\search\RolesSearch;
use app\models\PermissionGroups;
use ybsisgood\modules\UserManagement\models\rbacDB\Permission;

/**
 * AppsController implements the CRUD actions for Apps model.
 */
class AppsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-roles' => ['POST'],
                        'delete-permissions' => ['POST'],
                        'delete-permission-groups' => ['POST'],
                        'restore' => ['POST'],
                        'restore-roles' => ['POST'],
                        'restore-permissions' => ['POST'],
                        'restore-permission-groups' => ['POST'],
                    ],
                ],
                'ghost-access' => [
                    'class' => 'ybsisgood\modules\UserManagement\components\GhostAccessControl'
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new AppsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListDeleted()
    {
        if(Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'You are not allowed to access this page.');
            return $this->redirect(['index']);
        }
        $searchModel = new AppsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $deleted = true);

        return $this->render('list-deleted', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRolesDeleted($id)
    {
        if(Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'You are not allowed to access this page.');
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        $searchModel = new RolesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $model->id, $deleted = true);

        return $this->render('list-roles-deleted', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionListPermissionGroupsDeleted($id)
    {
        if(Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'You are not allowed to access this page.');
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        $searchModel = new PermissionGroupsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $model->id, $deleted = true);

        return $this->render('list-permission-groups-deleted', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionView($seo_url)
    {
        $model = $this->findModelbyUrl($seo_url);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Apps();
        
        if ($this->request->isPost) {
            $detailInfo = GlobalFunction::changeLogCreate();
            $model->detail_info = $detailInfo;
            if ($model->load($this->request->post()) && $model->save()) {
                $model->detail_info = $detailInfo;
                $model->seo_url = GlobalFunction::slugify($model->name).'-'.$model->id;
                $model->save();
                $createSuperadmin = new Roles();
                $createSuperadmin->app_id = $model->id;
                $createSuperadmin->name = 'Superadmin';
                $createSuperadmin->code_roles = 'superadmin';
                $createSuperadmin->status = Roles::STATUS_ACTIVE;
                $createSuperadmin->detail_info = GlobalFunction::changeLogCreate();
                $createSuperadmin->save();
                $createAdmin = new Roles();
                $createAdmin->app_id = $model->id;
                $createAdmin->name = 'Admin';
                $createAdmin->code_roles = 'admin';
                $createAdmin->status = Roles::STATUS_ACTIVE;
                $createAdmin->detail_info = GlobalFunction::changeLogCreate();
                $createAdmin->save();
                $createUncommonPermission = new PermissionGroups();
                $createUncommonPermission->app_id = $model->id;
                $createUncommonPermission->name = 'Uncommon Permission';
                $createUncommonPermission->code_permission_groups = 'uncommonPermission';
                $createUncommonPermission->status = PermissionGroups::STATUS_ACTIVE;
                $createUncommonPermission->detail_info = GlobalFunction::changeLogCreate();
                $createUncommonPermission->save();
                Yii::$app->session->setFlash('success', 'Data has been created.');
                return $this->redirect(['view', 'seo_url' => $model->seo_url]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($seo_url)
    {
        $model = $this->findModelbyUrl($seo_url);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            if(empty($model->getDirtyAttributes())) {
                Yii::$app->session->setFlash('success', 'Nothing has been changed.');
                return $this->redirect(['view', 'seo_url' => $model->seo_url]);
            }
            $detailInfo = GlobalFunction::changeLogUpdate($model->detail_info);
            $model->detail_info = $detailInfo;
            $model->save();
            Yii::$app->session->setFlash('success', 'Data has been updated.');
            return $this->redirect(['view', 'seo_url' => $model->seo_url]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionRoles($seo_url)
    {
        $model = $this->findModelbyUrl($seo_url);
        $searchModel = new RolesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $model->id);
        $newRole = new Roles();

        if ($this->request->isPost) {
            $detailInfo = GlobalFunction::changeLogCreate();
            $newRole->detail_info = $detailInfo;
            $newRole->app_id = $model->id;
            if ($newRole->load($this->request->post()) && $newRole->validate()) {
                $checkRole = Roles::find()->where(['app_id' => $model->id, 'name' => $newRole->code_roles])->one();
                if(!empty($checkRole)) {
                    Yii::$app->session->setFlash('error', 'Code role already exists.');
                    return $this->redirect(['roles', 'seo_url' => $model->seo_url]);
                }
                $newRole->save();
                Yii::$app->session->setFlash('success', 'Data has been created.');
                return $this->redirect(['roles', 'seo_url' => $model->seo_url]);
            }
        }

        return $this->render('roles', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'newRole' => $newRole
        ]);
    }

    public function actionViewRoles($id, $code_roles)
    {
        $roles = $this->findRolesModel($id);
        if(empty($roles) || $roles->code_roles != $code_roles) { 
            Yii::$app->session->setFlash('error', 'Data not found.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $apps = $this->findModel($roles->app_id);
        
        return $this->render('view-roles', [
            'apps' => $apps,
            'roles' => $roles
        ]);
    }

    public function actionUpdateRoles($id, $code_roles)
    {
        $updateRole = $this->findRolesModel($id);
        if($updateRole->code_roles == 'superadmin' || $updateRole->code_roles == 'admin') {
            Yii::$app->session->setFlash('error', 'Superadmin and Admin cannot be edited.');
            return $this->redirect(['view-roles', 'id' => $id, 'code_roles' => $updateRole->code_roles]);
        }
        if($updateRole->code_roles != $code_roles) {
            Yii::$app->session->setFlash('error', 'Data not found.');
            return $this->redirect(['view-roles', 'id' => $id, 'code_roles' => $updateRole->code_roles]);
        }

        if ($this->request->isPost && $updateRole->load($this->request->post()) && $updateRole->validate()) {
            $updateRole->status = intval($updateRole->status);
            if(empty($updateRole->getDirtyAttributes())) {
                Yii::$app->session->setFlash('success', 'Nothing has been changed.');
                return $this->redirect(['view-roles', 'id' => $id, 'code_roles' => $updateRole->code_roles]);
            }
            $detailInfo = GlobalFunction::changeLogUpdate($updateRole->detail_info);
            $updateRole->detail_info = $detailInfo;
            $updateRole->save();
            Yii::$app->session->setFlash('success', 'Data has been updated.');
            return $this->redirect(['view-roles', 'id' => $id, 'code_roles' => $updateRole->code_roles]);
        }
        return $this->render('update-roles', [
            'updateRole' => $updateRole
        ]);
    }

    public function actionPermissionGroups($seo_url) {
        $model = $this->findModelbyUrl($seo_url);
        $searchModel = new PermissionGroupsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $model->id);
        
        $newPermissionGroups = new PermissionGroups();

        if ($this->request->isPost) {
            $detailInfo = GlobalFunction::changeLogCreate();
            $newPermissionGroups->detail_info = $detailInfo;
            $newPermissionGroups->app_id = $model->id;
            if ($newPermissionGroups->load($this->request->post()) && $newPermissionGroups->validate()) {
                $checkPermissionGroups = PermissionGroups::find()->where(['app_id' => $model->id, 'code_permission_groups' => $newPermissionGroups->code_permission_groups])->one();
                if(!empty($checkPermissionGroups)) {
                    Yii::$app->session->setFlash('error', 'Code permission groups already exists.');
                    return $this->redirect(['permission-groups', 'seo_url' => $model->seo_url]);
                }
                $newPermissionGroups->save();
                Yii::$app->session->setFlash('success', 'Data has been created.');
                return $this->redirect(['permission-groups', 'seo_url' => $model->seo_url]);
            }
        }

        return $this->render('permission-groups', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'newPermissionGroups' => $newPermissionGroups
        ]);
    }

    public function actionViewPermissionGroups($id, $code_permission_groups) {
        $permissionGroups = $this->findPermissionGroupsModel($id);
        if(empty($permissionGroups) || $permissionGroups->code_permission_groups != $code_permission_groups) { 
            Yii::$app->session->setFlash('error', 'Data not found.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $apps = $this->findModel($permissionGroups->app_id);
        
        return $this->render('view-permission-groups', [
            'apps' => $apps,
            'permissionGroups' => $permissionGroups
        ]);
        
    }

    public function actionUpdatePermissionGroups($id, $code_permission_groups) {
        $permissionGroups = $this->findPermissionGroupsModel($id);
        if(empty($permissionGroups) || $permissionGroups->code_permission_groups != $code_permission_groups) {
            Yii::$app->session->setFlash('error', 'Data not found.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($this->request->isPost && $permissionGroups->load($this->request->post()) && $permissionGroups->validate()) {
            $permissionGroups->status = intval($permissionGroups->status);
            if(empty($permissionGroups->getDirtyAttributes())) {
                Yii::$app->session->setFlash('success', 'Nothing has been changed.');
                return $this->redirect(['view-permission-groups', 'id' => $permissionGroups->id, 'code_permission_groups' => $permissionGroups->code_permission_groups]);
            }
            $detailInfo = GlobalFunction::changeLogUpdate($permissionGroups->detail_info);
            $permissionGroups->detail_info = $detailInfo;
            $permissionGroups->save();
            Yii::$app->session->setFlash('success', 'Data has been updated.');
            return $this->redirect(['view-permission-groups', 'id' => $permissionGroups->id, 'code_permission_groups' => $permissionGroups->code_permission_groups]);
        }
        return $this->render('update-permission-groups', [
            'permissionGroups' => $permissionGroups
        ]);
        
    }

    public function actionRestore($id) {
        $model = Apps::findOne($id);
        if($model->status != Apps::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data not has been deleted.');
            return $this->redirect(['index']);
        }
        $model->status = Apps::STATUS_INACTIVE;
        $model->detail_info = GlobalFunction::changeLogRestore($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been restored.');
        return $this->redirect(['index']);
    }

    public function actionRestoreRoles($id) {
        $model = Roles::findOne($id);
        if($model->status != Roles::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data not has been deleted.');
            return $this->redirect(['roles', 'seo_url' => $model->apps->seo_url]);
        }
        $model->status = Roles::STATUS_INACTIVE;
        $model->detail_info = GlobalFunction::changeLogRestore($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been restored.');
        return $this->redirect(['roles', 'seo_url' => $model->apps->seo_url]);
    }

    public function actionDeleteRoles($id)
    {
        $model = $this->findRolesModel($id);
        if($model->status == Roles::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data has been deleted.');
            return $this->redirect(['roles', 'seo_url' => $model->apps->seo_url]);
        }
        $model->status = Roles::STATUS_DELETED;
        $model->detail_info = GlobalFunction::changeLogDelete($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been deleted.');
        return $this->redirect(['roles', 'seo_url' => $model->apps->seo_url]);
    }   

    public function actionRestorePermissionGroups($id) {
        $model = PermissionGroups::findOne($id);
        if($model->status != PermissionGroups::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data not has been deleted.');
            return $this->redirect(['permission-groups', 'seo_url' => $model->apps->seo_url]);
        }
        $model->status = PermissionGroups::STATUS_INACTIVE;
        $model->detail_info = GlobalFunction::changeLogRestore($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been restored.');
        return $this->redirect(['permission-groups', 'seo_url' => $model->apps->seo_url]);
    }

    public function actionDeletePermissionGroups($id) {
        $model = $this->findPermissionGroupsModel($id);
        if($model->status == PermissionGroups::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data has been deleted.');
            return $this->redirect(['permission-groups', 'seo_url' => $model->apps->seo_url]);
        }
        $model->status = PermissionGroups::STATUS_DELETED;
        $model->detail_info = GlobalFunction::changeLogDelete($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been deleted.');
        return $this->redirect(['permission-groups', 'seo_url' => $model->apps->seo_url]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Apps::STATUS_DELETED;
        $model->detail_info = GlobalFunction::changeLogDelete($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been deleted.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Apps::find()->where(['id' => $id])->andWhere(['!=', 'status', Apps::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPermissionGroupsModel($id)
    {
        if (($model = PermissionGroups::find()->where(['id' => $id])->andWhere(['!=', 'status', PermissionGroups::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findRolesModel($id)
    {
        if (($model = Roles::find()->where(['id' => $id])->andWhere(['!=', 'status', Roles::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelbyUrl($seo_url)
    {
        if (($model = Apps::find()->where(['seo_url' => $seo_url])->andWhere(['!=', 'status', Apps::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
