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
use app\models\search\RolesSearch;

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

        return $this->render('roles', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model = $this->findModel($id);
        $model->status = Apps::STATUS_DELETED;
        $model->detail_info = GlobalFunction::changeLogDelete($model->detail_info);
        $model->save();
        Yii::$app->session->setFlash('success', 'Data has been deleted.');
        return $this->redirect(Yii::$app->request->referrer);
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
