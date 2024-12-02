<?php

namespace app\controllers;

use Yii;
use app\models\Apps;
use app\models\search\AppsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalFunction;

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
                    ],
                ],
                'ghost-access' => [
                    'class' => 'ybsisgood\modules\UserManagement\components\GhostAccessControl'
                ],
            ]
        );
    }

    /**
     * Lists all Apps models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AppsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apps model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($seo_url)
    {
        $model = $this->findModelbyUrl($seo_url);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Apps model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Apps();
        
        if ($this->request->isPost) {
            $detailInfo = GlobalFunction::changeLogCreate();
            $model->detail_info = $detailInfo;
            $detailInfo['change_log']['created_at'] = date('Y-m-d\TH:i:sP', strtotime('now'));
            $detailInfo['change_log']['created_by'] = Yii::$app->user->identity->username;
            if ($model->load($this->request->post()) && $model->save()) {
                $model->detail_info = $detailInfo;
                $model->seo_url = GlobalFunction::slugify($model->name).'-'.$model->id;
                $model->save();
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

    /**
     * Updates an existing Apps model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Apps model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Apps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apps::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelbyUrl($seo_url)
    {
        if (($model = Apps::findOne(['seo_url' => $seo_url])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
