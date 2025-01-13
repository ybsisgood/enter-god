<?php

namespace app\controllers;

use app\models\Employees;
use app\models\search\EmployeesSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use ybsisgood\helpers\LittleBigHelper;

use app\components\GlobalFunction;
use app\models\Apps;
use app\models\Permissions;
use app\models\Roles;

/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class EmployeesController extends Controller
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
                    ],
                ],
                'ghost-access' => [
                    'class' => 'ybsisgood\modules\UserManagement\components\GhostAccessControl'
                ],
            ]
        );
    }

    /**
     * Lists all Employees models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmployeesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $deleted = false);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employees model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Employees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Employees();
        $model->scenario = Employees::SCENARIO_CREATE;
        $detail_info = [];
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $searchUsername = Employees::find()->where(['username' => $model->username])->one();
                if ($searchUsername) {
                    $model->addError('username', 'Username already exists');
                    Yii::$app->session->setFlash('error', 'Username already exists');
                    return $this->redirect(['create']);
                }
                $searchEmail = Employees::find()->where(['email' => $model->email])->one();
                if ($searchEmail) {
                    $model->addError('email', 'Email already exists');
                    Yii::$app->session->setFlash('error', 'Email already exists');
                    return $this->redirect(['create']);
                }
                $detail_info = GlobalFunction::changeLogCreate();
                $model->username = strtolower($_POST['Employees']['username']);
                $model->detail_info = $detail_info;
                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
                $model->registration_ip = LittleBigHelper::getRealIp();
                $model->save();
                Yii::$app->session->setFlash('success', 'Data has been created.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataEmailLama = $model->email;
        $model->scenario = Employees::SCENARIO_UPDATE;
        
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            if($dataEmailLama != $model->email) {
                $searchEmail = Employees::find()->where(['email' => $model->email])->one();
                if ($searchEmail) {
                    $model->addError('email', 'Email already exists');
                    Yii::$app->session->setFlash('error', 'Email already exists');
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
            $detail_info = GlobalFunction::changeLogUpdate($model->detail_info);
            $model->detail_info = $detail_info;
            $model->save();
            Yii::$app->session->setFlash('success', 'Data has been updated.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->newPassword);
                $model->save();
                Yii::$app->session->setFlash('success', 'Data has been updated.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    public function actionSetupRoles($id)
    {
        $model = $this->findModel($id);
        $listApps = Apps::find()->where(['!=', 'status', Apps::STATUS_DELETED])->all();
        $listRoles = Roles::find()->where(['!=', 'status', Roles::STATUS_DELETED])->all();

        $detail_info = $model->detail_info;
        $getRoleNow = $detail_info['sso']['rolesID'] ?? [];
        $getPermissionNow = $detail_info['sso']['permissionsID'] ?? [];

        if ($this->request->isPost) {
            $detail_info = GlobalFunction::changeLogUpdate($detail_info);
            Yii::$app->session->setFlash('success', 'Data has been updated.');
            $getValue = $_POST['role'] ?? [];
            if(!empty($getValue)) {
                $searchRoles = Roles::find()->where(['in', 'id', $getValue])->all();
                $allSaveRole = [];
                foreach ($searchRoles as $key => $value) {
                    if(!isset($allSaveRole[$value->apps->code_app])) {
                        $allSaveRole[$value->apps->code_app]['superadmin'] = false;
                        $allSaveRole[$value->apps->code_app]['admin'] = false;
                        $allSaveRole[$value->apps->code_app]['roles'] = [];
                        $allSaveRole[$value->apps->code_app]['permissions'] = [];
                        if($value->code_roles == 'superadmin') {
                            $allSaveRole[$value->apps->code_app]['superadmin'] = true;
                        } else if($value->code_roles == 'admin') {
                            $allSaveRole[$value->apps->code_app]['admin'] = true;
                        }  else {
                            $allSaveRole[$value->apps->code_app]['roles'][] = $value->code_roles;
                        } 
                        // permission 
                        if(isset($value->permission_json['permissionsCode'])) {
                            $allSaveRole[$value->apps->code_app]['permissions'] = $value->permission_json['permissionsCode'];
                        }
                    } else {
                        if($value->code_roles == 'superadmin') {
                            $allSaveRole[$value->apps->code_app]['superadmin'] = true;
                        } else if($value->code_roles == 'admin') {
                            $allSaveRole[$value->apps->code_app]['admin'] = true;
                        }  else {
                            if(isset($allSaveRole[$value->apps->code_app]['roles'])) {
                                $allSaveRole[$value->apps->code_app]['roles'] = array_merge($allSaveRole[$value->apps->code_app]['roles'], [$value->code_roles]);
                            } else {
                                $allSaveRole[$value->apps->code_app]['roles'][] = $value->code_roles;
                            }
                        }
                        // permission
                        if(isset($value->permission_json['permissionsCode'])) {
                            if(isset($allSaveRole[$value->apps->code_app]['permissions'])) {
                                $allSaveRole[$value->apps->code_app]['permissions'] = array_merge($allSaveRole[$value->apps->code_app]['permissions'], $value->permission_json['permissionsCode']);
                            } else {
                                $allSaveRole[$value->apps->code_app]['permissions'] = $value->permission_json['permissionsCode'];
                            }
                        }
                    }

                    if(isset($value->permission_json['permissionsID'])) {
                        $getPermissionNow = array_unique(array_merge($getPermissionNow, $value->permission_json['permissionsID']));
                    }
                    
                }
                $detail_info['sso'] = $allSaveRole;
                $detail_info['sso']['rolesID'] = $getValue;
                $detail_info['sso']['permissionsID'] = $getPermissionNow;
                $model->detail_info = $detail_info;
                $model->save();
                Yii::$app->session->setFlash('success', 'Data has been updated.');
                return $this->redirect(['setup-roles', 'id' => $model->id]);
            } else {
                $detail_info['sso'] = [];
                $detail_info['sso']['rolesID'] = [];
                $detail_info['sso']['permissionsID'] = [];
                $model->detail_info = $detail_info;
                $model->save();
                Yii::$app->session->setFlash('success', 'Data has been updated.');
                return $this->redirect(['setup-roles', 'id' => $model->id]);
            }

        }

        return $this->render('setup-roles', [
            'model' => $model,
            'listApps' => $listApps,
            'listRoles' => $listRoles,
            'getRoleNow' => $getRoleNow
        ]);
    }

    public function actionSetupPermissions($id) {
        $model = $this->findModel($id);
        if(!isset($model->detail_info['sso']) || empty($model->detail_info['sso']['rolesID'])) {
            Yii::$app->session->setFlash('error', 'Please setup roles first.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $listApps = Apps::find()->where(['!=', 'status', Apps::STATUS_DELETED])->all();
        $listPermissions = Permissions::find()->where(['!=', 'status', Permissions::STATUS_DELETED])->all();
        $getPermissionNow = $model->detail_info['sso']['permissionsID'] ?? [];

        $detail_info = $model->detail_info;
        if ($this->request->isPost) {
            $detail_info = GlobalFunction::changeLogUpdate($detail_info);
            $getValue = $_POST['permission'];
            if(!empty($getValue)) {
                $detail_info['sso']['permissionsID'] = $getValue;
                $model->detail_info = $detail_info;
                $model->save();
                Yii::$app->session->setFlash('success', 'Data has been updated.');
                return $this->redirect(['setup-permissions', 'id' => $model->id]);
            }
        }

        return $this->render('setup-permissions', [
            'model' => $model,
            'listApps' => $listApps,
            'listPermissions' => $listPermissions,
            'getPermissionNow' => $getPermissionNow
        ]);
    }

    /**
     * Deletes an existing Employees model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Employees::STATUS_DELETED;
        $model->detail_info = GlobalFunction::changeLogDelete($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been deleted.');
        return $this->redirect(['index']);
    }

    public function actionRestore($id) {
        $model = Employees::findOne($id);
        if($model->status != Employees::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data not has been deleted.');
            return $this->redirect(['index']);
        } 
        $model->status = Employees::STATUS_INACTIVE;
        $model->detail_info = GlobalFunction::changeLogRestore($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been restored.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Employees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Employees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employees::findOne(['id' => $id])) !== null && $model->status != Employees::STATUS_DELETED) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
