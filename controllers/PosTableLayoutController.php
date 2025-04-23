<?php

namespace app\controllers;

use Yii;
use app\components\GlobalFunction;
use app\models\PosOutlet;
use app\models\PosTableLayout;
use app\models\search\PosTableLayoutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PosTableLayoutController implements the CRUD actions for PosTableLayout model.
 */
class PosTableLayoutController extends Controller
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
     * Lists all PosTableLayout models.
     *
     * @return string
     */
    public function actionIndex($outletID)
    {
        $searchModel = new PosTableLayoutSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, false, $outletID);
        $outlet = PosOutlet::findOne($outletID);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'outlet' => $outlet,
        ]);
    }

    public function actionListDeleted($outletID)
    {
        if(Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'You are not allowed to access this page.');
            return $this->redirect(['index', 'outletID' => $outletID]);
        }

        $searchModel = new PosTableLayoutSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, true, $outletID);
        $outlet = PosOutlet::findOne($outletID);

        return $this->render('list-deleted', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'outlet' => $outlet,
        ]);
    }

    /**
     * Displays a single PosTableLayout model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if($model->status == PosTableLayout::STATUS_DELETED && Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'You are not allowed to view this pos table layout.');
            return $this->redirect(['index', 'outletID' => $model->outlet_id]);
        }
        return $this->render('view', [
            'model' => $model,
            'outlet' => $model->outlet,
        ]);
    }

    /**
     * Creates a new PosTableLayout model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($outletID)
    {
        $model = new PosTableLayout();
        $model->scenario = PosTableLayout::SCENARIO_CREATE;
        $outlet = PosOutlet::findOne($outletID);
        if(empty($outlet)) {
            Yii::$app->session->setFlash('error', 'Outlet not found.');
            return $this->redirect(['pos-outlet/index']);
        }
        $model->outlet_id = $outletID;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $location = [];
                $location['position']['x'] = $model->layout_x;
                $location['position']['y'] = $model->layout_y;
                $location['size']['x'] = $model->layout_size_x;
                $location['size']['y'] = $model->layout_size_y;
                $location['shape'] = $model->layout_shape;
                $detailInfo = GlobalFunction::changeLogCreate();
                $model->detail_info = $detailInfo;
                $model->positioning = $location;
                $model->save();
                Yii::$app->session->setFlash('success', 'Pos Table Layout created successfully.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'outlet' => $outlet,
        ]);
    }

    /**
     * Updates an existing PosTableLayout model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = PosTableLayout::SCENARIO_UPDATE;
        $outlet = PosOutlet::findOne($model->outlet_id);
        if(empty($outlet)) {
            Yii::$app->session->setFlash('error', 'Outlet not found.');
            return $this->redirect(['pos-outlet/index']);
        }
        if($model->status == PosTableLayout::STATUS_DELETED && Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'Pos Table Layout already deleted.');
            return $this->redirect(['index', 'outletID' => $outlet->id]);
        }
        $layout = $model->positioning;
        $model->layout_x = $layout['position']['x'] ?? null;
        $model->layout_y = $layout['position']['y'] ?? null;
        $model->layout_size_x = $layout['size']['x'] ?? null;
        $model->layout_size_y = $layout['size']['y'] ?? null;
        $model->layout_shape = $layout['shape'] ?? null;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $location = [];
            $location['position']['x'] = $model->layout_x;
            $location['position']['y'] = $model->layout_y;
            $location['size']['x'] = $model->layout_size_x;
            $location['size']['y'] = $model->layout_size_y;
            $location['shape'] = $model->layout_shape;
            $model->positioning = $location;
            $detailInfo = GlobalFunction::changeLogUpdate($model->detail_info);
            $model->detail_info = $detailInfo;
            $model->save();
            Yii::$app->session->setFlash('success', 'Pos Table Layout updated successfully.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'outlet' => $outlet,
        ]);
    }

    /**
     * Deletes an existing PosTableLayout model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = PosTableLayout::STATUS_DELETED;
        $model->detail_info = GlobalFunction::changeLogDelete($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Pos Table Layout deleted successfully.');
        return $this->redirect(['index', 'outletID' => $model->outlet_id]);
    }

    public function actionRestore($id)
    {
        $model = $this->findModel($id);
        if($model->status != PosTableLayout::STATUS_DELETED && Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'You are not allowed to restore this pos table layout.');
            return $this->redirect(['index', 'outletID' => $model->outlet_id]);
        }
        $model->status = PosTableLayout::STATUS_INACTIVE;
        $model->detail_info = GlobalFunction::changeLogRestore($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Pos Table Layout restored successfully.');
        return $this->redirect(['list-deleted', 'outletID' => $model->outlet_id]);
    }


    /**
     * Finds the PosTableLayout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PosTableLayout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PosTableLayout::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
