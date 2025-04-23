<?php

namespace app\controllers;

use app\components\GlobalFunction;
use app\models\PosSession;
use app\models\search\PosSessionSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PosSessionController implements the CRUD actions for PosSession model.
 */
class PosSessionController extends Controller
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
     * Lists all PosSession models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PosSessionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PosSession model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if($model->status == PosSession::STATUS_DELETED && Yii::$app->user->identity->username != 'superadmin') {
            Yii::$app->session->setFlash('error', 'Pos Session already deleted.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PosSession model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->sync_slave = GlobalFunction::SYNC_SLAVE;
            $model->detail_info = GlobalFunction::changeLogUpdate($model->detail_info);
            $model->save();
            Yii::$app->session->setFlash('success', 'Pos Session updated successfully.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PosSession model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->status == PosSession::STATUS_DELETED)
        {
            Yii::$app->session->setFlash('error', 'Pos Session already deleted.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $model->status = PosSession::STATUS_DELETED;
        $model->sync_slave = GlobalFunction::SYNC_SLAVE;
        $model->detail_info = GlobalFunction::changeLogDelete($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Pos Session deleted successfully.');
        return $this->redirect(['index']);
    }

    public function actionRestore($id)
    {
        $model = $this->findModel($id);

        if($model->status != PosSession::STATUS_DELETED)
        {
            Yii::$app->session->setFlash('error', 'Pos Session not deleted.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $model->status = PosSession::STATUS_ACTIVE;
        $model->sync_slave = GlobalFunction::SYNC_SLAVE;
        $model->detail_info = GlobalFunction::changeLogRestore($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Pos Session restored successfully.');
        return $this->redirect(['index']);
    }

    /** 
     * Finds the PosSession model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PosSession the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PosSession::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
