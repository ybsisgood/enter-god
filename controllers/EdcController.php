<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PaymentVendor;
use app\models\PaymentCategories;
use app\models\search\PaymentVendorSearch;
use app\models\search\PaymentCategoriesSearch;
use app\components\GlobalFunction;
use yii\web\UploadedFile;

class EdcController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-vendor' => ['POST'],
                        'delete-category' => ['POST'],
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
        return $this->render('index');
    }

    /** LIST VENDOR */
    public function actionVendor()
    {
        $searchModel = new PaymentVendorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('vendor',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /** LIST DELETED VENDOR */
    public function actionListDeletedVendor()
    {
        $searchModel = new PaymentVendorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, true);
        return $this->render('list-deleted-vendor',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreateVendor()
    {
        $model = new PaymentVendor();
        $model->scenario = PaymentVendor::SCENARIO_CREATE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $checkCode = PaymentVendor::find()->where(['code' => $model->code])->one();
                if(!empty($checkCode)) {
                    Yii::$app->session->setFlash('error', 'Code already exists.');
                    return $this->redirect(['create-vendor']);
                }
                $detailInfo = GlobalFunction::changeLogCreate();
                $model->detail_info = $detailInfo;
                $model->save();
                Yii::$app->session->setFlash('success', 'Vendor created successfully.');
                return $this->redirect(['view-vendor', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create-vendor', [
            'model' => $model,
        ]);
    }

    public function actionViewVendor($id)
    {
        $model = $this->findModelVendor($id);
        return $this->render('view-vendor', [
            'model' => $model,
        ]);
    }

    public function actionUpdateVendor($id)
    {
        $model = $this->findModelVendor($id);
        $model->scenario = PaymentVendor::SCENARIO_UPDATE;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->status = intval($model->status);
            if(empty($model->getDirtyAttributes())) {
                Yii::$app->session->setFlash('success', 'Nothing has been changed.');
                return $this->redirect(['view-vendor', 'id' => $model->id]);
            }
            $detailInfo = GlobalFunction::changeLogUpdate($model->detail_info);
            $model->detail_info = $detailInfo;
            $model->save();
            Yii::$app->session->setFlash('success', 'Vendor updated successfully.');
            return $this->redirect(['view-vendor', 'id' => $model->id]);
        }        

        return $this->render('update-vendor', [
            'model' => $model,
        ]);
    }

    public function actionDeleteVendor($id)
    {
        $model = $this->findModelVendor($id);
        $model->status = PaymentVendor::STATUS_DELETED;
        $detailInfo = GlobalFunction::changeLogDelete($model->detail_info);
        $model->detail_info = $detailInfo;
        $model->save();
        Yii::$app->session->setFlash('success', 'Vendor deleted successfully.');
        return $this->redirect(['vendor']);
    }

    public function actionRestoreVendor($id)
    {
        $model = PaymentVendor::findOne($id);
        if($model->status != PaymentVendor::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data not has been deleted.');
            return $this->redirect(['list-deleted-vendor']);
        }
        $model->status = PaymentVendor::STATUS_INACTIVE;
        $detailInfo = GlobalFunction::changeLogRestore($model->detail_info);
        $model->detail_info = $detailInfo;
        $model->save();
        Yii::$app->session->setFlash('success', 'Vendor restored successfully.');
        return $this->redirect(['list-deleted-vendor']);
    }

    protected function findModelVendor($id)
    {
        if (($model = PaymentVendor::find()->where(['id' => $id])->andWhere(['!=', 'status', PaymentVendor::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    //  Payment Category
    public function actionCategory()
    {
        $searchModel = new PaymentCategoriesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('category',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionListDeletedCategory()
    {
        $searchModel = new PaymentCategoriesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, true);
        return $this->render('list-deleted-category',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreateCategory()
    {
        $model = new PaymentCategories();
        $model->scenario = PaymentCategories::SCENARIO_CREATE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $detailInfo = GlobalFunction::changeLogCreate();
                $model->detail_info = $detailInfo;
                $model->sort = 0;
                $model->save();
                Yii::$app->session->setFlash('success', 'Category created successfully.');
                return $this->redirect(['view-category', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create-category', [
            'model' => $model,
        ]);
    }

    public function actionViewCategory($id)
    {
        $model = $this->findModelCategory($id);
        return $this->render('view-category', [
            'model' => $model,
        ]);
    }

    public function actionUpdateCategory($id)
    {
        $model = $this->findModelCategory($id);
        $model->scenario = PaymentCategories::SCENARIO_UPDATE;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->status = intval($model->status);
            if(empty($model->getDirtyAttributes())) {
                Yii::$app->session->setFlash('success', 'Nothing has been changed.');
                return $this->redirect(['view-category', 'id' => $model->id]);
            }
            $detailInfo = GlobalFunction::changeLogUpdate($model->detail_info);
            $model->detail_info = $detailInfo;
            $model->save();
            Yii::$app->session->setFlash('success', 'Category updated successfully.');
            return $this->redirect(['view-category', 'id' => $model->id]);
        }

        return $this->render('update-category', [
            'model' => $model,
        ]);
    }

    public function actionUpdateImageCategory($id)
    {
        $model = $this->findModelCategory($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $file = UploadedFile::getInstance($model, 'imageFile');
            if (!empty($file)) {
                $fileName = $model->id . '-' . Yii::$app->security->generateRandomString(4) . '.' . $file->extension;
                $model->image_url = $fileName;
                $uploadPath = Yii::$app->params['imageCategoryPath'];
                $file->saveAs($uploadPath . $fileName);
            } else {
                Yii::$app->session->setFlash('error', 'Image Category not uploaded.');
                return $this->redirect(['view-category', 'id' => $model->id]);
            }
            $detailInfo = GlobalFunction::changeLogUpdate($model->detail_info);
            $model->detail_info = $detailInfo;
            $model->save();
            Yii::$app->session->setFlash('success', 'Category updated successfully.');
            return $this->redirect(['view-category', 'id' => $model->id]);
        }

        return $this->render('update-image-category', [
            'model' => $model,
        ]);
    }

    public function actionDeleteCategory($id)
    {
        $model = PaymentCategories::findOne($id);
        $model->status = PaymentCategories::STATUS_DELETED;
        $detailInfo = GlobalFunction::changeLogDelete($model->detail_info);
        $model->detail_info = $detailInfo;
        $model->save();
        Yii::$app->session->setFlash('success', 'Category deleted successfully.');
        return $this->redirect(['category']);
    }

    public function actionRestoreCategory($id)
    {
        $model = PaymentCategories::findOne($id);
        if($model->status != PaymentCategories::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data not has been deleted.');
            return $this->redirect(['list-deleted-category']);
        }
        $model->status = PaymentCategories::STATUS_INACTIVE;
        $detailInfo = GlobalFunction::changeLogRestore($model->detail_info);
        $model->detail_info = $detailInfo;
        $model->save();
        Yii::$app->session->setFlash('success', 'Category restored successfully.');
        return $this->redirect(['list-deleted-category']);
    }

    public function actionSortCategory()
    {   
        $allCategory = PaymentCategories::find()->where(['!=', 'status', PaymentCategories::STATUS_DELETED])->orderBy(['sort' => SORT_ASC])->all();

        $arrayList = [];

        foreach ($allCategory as $key => $value) {
            $arrayList[$value->id] = ['content' => $value->name . ' | ' . $value->getStatusList()[$value->status]];
        }

        $formList = new PaymentCategories();
        $formList->scenario = PaymentCategories::SCENARIO_SORT;
        if ($this->request->isPost) {
            if ($formList->load($this->request->post()) && $formList->validate()) {
                $array = explode(',', $formList->sortCategory);
                $i = 1;
                $inputJson = [];
                foreach ($array as $key => $v) {
                    $gallery = PaymentCategories::findOne($v);
                    $gallery->sort = $i;
                    $gallery->save();
                    $i++;
                }
                Yii::$app->session->setFlash('success', 'Category updated successfully.');
                return $this->redirect(['category']);
            }
        }

        return $this->render('sort-category', [
            'formList' => $formList,
            'arrayList' => $arrayList
        ]);
    }

    protected function findModelCategory($id)
    {
        if (($model = PaymentCategories::find()->where(['id' => $id])->andWhere(['!=', 'status', PaymentCategories::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

 
}