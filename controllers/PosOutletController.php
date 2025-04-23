<?php

namespace app\controllers;

use app\components\GlobalFunction;
use app\models\PosOutlet;
use app\models\search\PosOutletSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PosOutletController implements the CRUD actions for PosOutlet model.
 */
class PosOutletController extends Controller
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
                        'restore' => ['POST'],
                    ],
                ],
                'ghost-access' => [
                    'class' => 'ybsisgood\modules\UserManagement\components\GhostAccessControl'
                ],
            ]
        );
    }

    /**
     * Lists all PosOutlet models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PosOutletSearch();
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

        $searchModel = new PosOutletSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $deleted = true);

        return $this->render('list-deleted', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PosOutlet model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $slug_url)
    {
        $model = $this->findModel($id);
        if($model->slug_url != $slug_url){
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($model->status == PosOutlet::STATUS_DELETED && Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'Pos Outlet already deleted.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $model->location_lat = $model->location['lat'] ?? null;
        $model->location_lng = $model->location['lng'] ?? null;
        $model->ip_whitelist = json_decode($model->ip_whitelist ?? null);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new PosOutlet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PosOutlet();
        $model->scenario = PosOutlet::SCENARIO_CREATE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $model->secret_key = Yii::$app->security->generateRandomString();
                if(!empty($_POST['PosOutlet']['ip_whitelist'])){
                    $model->ip_whitelist = implode(',', $_POST['PosOutlet']['ip_whitelist']);
                }
                $detail_info = GlobalFunction::changeLogCreate();
                $loc = [];
                $loc['lat'] = $_POST['PosOutlet']['location_lat'];
                $loc['lng'] = $_POST['PosOutlet']['location_lng'];
                $model->location = $loc;
                $model->detail_info = $detail_info;
                $model->slug_url = GlobalFunction::slugify($_POST['PosOutlet']['name']);
                $model->sync_slave = GlobalFunction::SYNC_SLAVE;
                $model->save();
                Yii::$app->session->setFlash('success', 'Pos Outlet created successfully.');
                return $this->redirect(['view', 'id' => $model->id, 'slug_url' => $model->slug_url]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PosOutlet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $slug_url)
    {
        $model = $this->findModel($id);
        if($model->slug_url != $slug_url){
            Yii::$app->session->setFlash('error', 'Pos Outlet not found');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($model->status == PosOutlet::STATUS_DELETED && Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'Pos Outlet already deleted.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $model->location_lat = $model->location['lat'] ?? null;
        $model->location_lng = $model->location['lng'] ?? null;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            if(!empty($_POST['PosOutlet']['ip_whitelist'])){
                $model->ip_whitelist = implode(',', $_POST['PosOutlet']['ip_whitelist']);
            }
            $detail_info = GlobalFunction::changeLogUpdate($model->detail_info);
            $loc = [];
            $loc['lat'] = $_POST['PosOutlet']['location_lat'];
            $loc['lng'] = $_POST['PosOutlet']['location_lng'];
            $model->location = $loc;
            $model->detail_info = $detail_info;
            $model->slug_url = GlobalFunction::slugify($_POST['PosOutlet']['name']);
            $model->sync_slave = GlobalFunction::SYNC_SLAVE;
            $model->save();
            Yii::$app->session->setFlash('success', 'Pos Outlet updated successfully.');
            return $this->redirect(['view', 'id' => $model->id, 'slug_url' => $model->slug_url]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PosOutlet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->status == PosOutlet::STATUS_DELETED)
        {
            Yii::$app->session->setFlash('error', 'Pos Outlet already deleted.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model->detail_info = GlobalFunction::changeLogDelete($model->detail_info);
        $model->status = PosOutlet::STATUS_DELETED;
        $model->sync_slave = GlobalFunction::SYNC_SLAVE;
        $model->save();
        Yii::$app->session->setFlash('success', 'Pos Outlet deleted successfully.');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRestore($id)
    {
        $model = PosOutlet::findOne($id);
        if($model->status == PosOutlet::STATUS_DELETED && Yii::$app->user->identity->username == 'superadmin')
        {
            $model->detail_info = GlobalFunction::changeLogRestore($model->detail_info);
            $model->status = PosOutlet::STATUS_INACTIVE;
            $model->sync_slave = GlobalFunction::SYNC_SLAVE;
            $model->save();
            Yii::$app->session->setFlash('success', 'Pos Outlet restored successfully.');
            return $this->redirect(['list-deleted']);
        }
        Yii::$app->session->setFlash('error', 'Pos Outlet not found.');
        return $this->redirect(Yii::$app->request->referrer);   
    }

    /**
     * Finds the PosOutlet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PosOutlet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PosOutlet::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
