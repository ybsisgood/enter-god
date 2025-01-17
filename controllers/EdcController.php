<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PaymentVendor;
use app\models\PaymentCategories;
use app\models\PaymentChannels;
use app\models\search\PaymentVendorSearch;
use app\models\search\PaymentCategoriesSearch;
use app\models\search\PaymentChannelsSearch;
use app\components\GlobalFunction;
use app\models\PaymentAccounts;
use app\models\search\PaymentAccountsSearch;
use yii\helpers\ArrayHelper;
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
                        'delete-vendor' => ['POST'],
                        'delete-category' => ['POST'],
                        'restore-vendor' => ['POST'],
                        'restore-category' => ['POST'],
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
        $oldCode = $model->code;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->status = intval($model->status);
            if(empty($model->getDirtyAttributes())) {
                Yii::$app->session->setFlash('success', 'Nothing has been changed.');
                return $this->redirect(['view-category', 'id' => $model->id]);
            }
            $detailInfo = GlobalFunction::changeLogUpdate($model->detail_info);
            if($model->code != $oldCode) {
                $checkCode = PaymentCategories::find()->where(['code' => $model->code])->one();
                if(!empty($checkCode)) {
                    Yii::$app->session->setFlash('error', 'Code already exists.');
                    return $this->redirect(['update-category', 'id' => $model->id]);
                }
            }
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
                Yii::$app->session->setFlash('success', 'Category sorted successfully.');
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

    // Channel

    public function actionChannel()
    {
        $searchModel = new PaymentChannelsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('channel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListDeletedChannel()
    {
        $searchModel = new PaymentChannelsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, true);

        return $this->render('list-deleted-channel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateChannel()
    {
        $model = new PaymentChannels(); 
        $model->scenario = PaymentChannels::SCENARIO_CREATE;    
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $detailInfo = GlobalFunction::changeLogCreate();
                $getCategory = PaymentCategories::findOne($model->payment_category_id);
                if(empty($getCategory)) {
                    Yii::$app->session->setFlash('error', 'Category not found.');
                    return $this->redirect(['create-channel']);
                }
                $checkCode = PaymentChannels::find()->where(['code' => $model->code])->one();
                if(!empty($checkCode)) {
                    Yii::$app->session->setFlash('error', 'Code already exists.');
                    return $this->redirect(['create-channel']);
                }
                $detailInfo['category']['name'] = $getCategory->name;
                $detailInfo['category']['id'] = $model->payment_category_id;
                $model->detail_info = $detailInfo;
                $model->save();
                Yii::$app->session->setFlash('success', 'Channel created successfully.');
                return $this->redirect(['view-channel', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $listPaymentCategory = PaymentCategories::find()->where(['!=', 'status', PaymentCategories::STATUS_DELETED])->orderBy(['sort' => SORT_ASC])->all();
        $listPC = ArrayHelper::map($listPaymentCategory, 'id', 'name');

        return $this->render('create-channel', [
            'model' => $model,
            'listPC' => $listPC,
        ]);
    }


    public function actionViewChannel($id)
    {
        return $this->render('view-channel', [
            'model' => $this->findModelChannel($id),
        ]);
    }

    public function actionUpdateChannel($id)
    {
        $model = $this->findModelChannel($id);
        $model->scenario = PaymentChannels::SCENARIO_UPDATE;
        $oldCode = $model->code;
        $oldCategory = $model->payment_category_id;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->status = intval($model->status);
            if(empty($model->getDirtyAttributes())) {
                Yii::$app->session->setFlash('success', 'Nothing has been changed.');
                return $this->redirect(['view-channel', 'id' => $model->id]);
            }
            if($model->code != $oldCode) {
                $checkCode = PaymentChannels::find()->where(['code' => $model->code])->one();
                if(!empty($checkCode)) {
                    Yii::$app->session->setFlash('error', 'Code already exists.');
                    return $this->redirect(['update-channel', 'id' => $model->id]);
                }
            }
            $detailInfo = GlobalFunction::changeLogUpdate($model->detail_info);
            if($model->payment_category_id != $oldCategory) {
                $getCategory = PaymentCategories::findOne($model->payment_category_id);
                if(empty($getCategory)) {
                    Yii::$app->session->setFlash('error', 'Category not found.');
                    return $this->redirect(['update-channel', 'id' => $model->id]);
                }
                $detailInfo['category']['name'] = $getCategory->name;
                $detailInfo['category']['id'] = $model->payment_category_id;
            }
            $model->detail_info = $detailInfo;
            $model->save();
            Yii::$app->session->setFlash('success', 'Channel updated successfully.');
            return $this->redirect(['view-channel', 'id' => $model->id]);
        }

        $listPaymentCategory = PaymentCategories::find()->where(['!=', 'status', PaymentCategories::STATUS_DELETED])->orderBy(['sort' => SORT_ASC])->all();
        $listPC = ArrayHelper::map($listPaymentCategory, 'id', 'name');

        return $this->render('update-channel', [
            'model' => $model,
            'listPC' => $listPC,
        ]);
    }

    public function actionUpdateImageChannel($id)
    {
        $model = $this->findModelChannel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $file = UploadedFile::getInstance($model, 'imageFile');
            if(!empty($file)) {
                $fileName = $model->id . '-' . Yii::$app->security->generateRandomString(4) . '.' . $file->extension;
                $model->image_url = $fileName;
                $uploadPath = Yii::$app->params['imageChannelPath'];
                $file->saveAs($uploadPath . $fileName);
            } else {
                Yii::$app->session->setFlash('error', 'Image not uploaded.');
                return $this->redirect(['view-channel', 'id' => $model->id]);
            }
            $model->save();
            Yii::$app->session->setFlash('success', 'Image updated successfully.');
            return $this->redirect(['view-channel', 'id' => $model->id]);
        }
        return $this->render('update-image-channel', [
            'model' => $model,
        ]);
    }

    public function actionSortChannel()
    {
        $allChannels = PaymentChannels::find()->where(['!=', 'status', PaymentChannels::STATUS_DELETED])->orderBy(['sort' => SORT_ASC])->all();
        
        $arrayList = [];
        foreach($allChannels as $channel) {
            $arrayList[$channel->id] = ['content' => $channel->name . ' | ' . $channel->getStatusList()[$channel->status]];
        }

        $formList = new PaymentChannels();
        $formList->scenario = PaymentChannels::SCENARIO_SORT;
        if ($this->request->isPost) {
            if ($formList->load($this->request->post()) && $formList->validate()) {
                $array = explode(',', $formList->sortChannels);
                $i = 1;
                $inputJson = [];
                foreach ($array as $key => $v) {
                    $gallery = PaymentChannels::findOne($v);
                    $gallery->sort = $i;
                    $gallery->save();
                    $i++;
                }
                Yii::$app->session->setFlash('success', 'Channel sorted successfully.');
                return $this->redirect(['channel']);
            }
        }
        
        return $this->render('sort-channel', [
            'formList' => $formList,
            'arrayList' => $arrayList,
        ]);
    }

    public function actionDeleteChannel($id)
    {
        $model = $this->findModelChannel($id);
        $model->status = PaymentChannels::STATUS_DELETED;
        $detailInfo = GlobalFunction::changeLogDelete($model->detail_info);
        $model->detail_info = $detailInfo;
        $model->save();
        Yii::$app->session->setFlash('success', 'Channel deleted successfully.');
        return $this->redirect(['channel']);
    }

    public function actionRestoreChannel($id)
    {
        $model = PaymentChannels::findOne($id);
        if($model->status != PaymentChannels::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data not has been deleted.');
            return $this->redirect(['list-deleted-channel']);
        }
        $model->status = PaymentChannels::STATUS_INACTIVE;
        $detailInfo = GlobalFunction::changeLogRestore($model->detail_info);
        $model->detail_info = $detailInfo;
        $model->save();
        Yii::$app->session->setFlash('success', 'Channel restored successfully.');
        return $this->redirect(['list-deleted-channel']);
    }

    protected function findModelChannel($id)
    {
        if (($model = PaymentChannels::find()->where(['id' => $id])->andWhere(['!=', 'status', PaymentChannels::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // Payment Account

    public function actionAccount()
    {
        $searchModel = new PaymentAccountsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('account', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListDeletedAccount()
    {
        $searchModel = new PaymentAccountsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, true);
        return $this->render('list-deleted-account', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateAccount()
    {
        $model = new PaymentAccounts();
        $model->scenario = PaymentAccounts::SCENARIO_CREATE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                $detailInfo = GlobalFunction::changeLogCreate();
                $getVendor = PaymentVendor::findOne($model->payment_vendor_id);
                $getCategory = PaymentCategories::findOne($model->payment_category_id);
                $getChannel = PaymentChannels::findOne($model->payment_channel_id);
                if(empty($getVendor) || empty($getCategory) || empty($getChannel)) {
                    Yii::$app->session->setFlash('error', 'Vendor/Category/Channel not found.');
                    return $this->redirect(['create-account']);
                }
                $detailInfo['vendor']['id'] = $model->payment_vendor_id;
                $detailInfo['vendor']['name'] = $getVendor->name;
                $detailInfo['category']['id'] = $model->payment_category_id;
                $detailInfo['category']['name'] = $getCategory->name;
                $detailInfo['channel']['id'] = $model->payment_channel_id;
                $detailInfo['channel']['name'] = $getChannel->name;
                $model->detail_info = $detailInfo;
                $model->save();
                Yii::$app->session->setFlash('success', 'Account created successfully.');
                return $this->redirect(['view-account', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $vendor = PaymentVendor::find()->where(['!=', 'status', PaymentVendor::STATUS_DELETED])->all();
        $vendorList = ArrayHelper::map($vendor, 'id', 'name');

        $category = PaymentCategories::find()->where(['!=', 'status', PaymentCategories::STATUS_DELETED])->all();
        $categoryList = ArrayHelper::map($category, 'id', 'name');

        $channel = PaymentChannels::find()->where(['!=', 'status', PaymentChannels::STATUS_DELETED])->all();
        $channelList = ArrayHelper::map($channel, 'id', 'name');

        return $this->render('create-account', [
            'model' => $model,
            'vendorList' => $vendorList,
            'categoryList' => $categoryList,
            'channelList' => $channelList,
        ]);
    }

    public function actionViewAccount($id)
    {
        return $this->render('view-account', [
            'model' => $this->findModelAccount($id),
        ]);
    }

    public function actionUpdateAccount($id)
    {
        $model = $this->findModelAccount($id);
        $model->scenario = PaymentAccounts::SCENARIO_UPDATE;
        $oldVendor = $model->payment_vendor_id;
        $oldCategory = $model->payment_category_id;
        $oldChannel = $model->payment_channel_id;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $detailInfo = GlobalFunction::changeLogUpdate($model->detail_info);
            $intVendor = intval($model->payment_vendor_id);
            $intCategory = intval($model->payment_category_id);
            $intChannel = intval($model->payment_channel_id);
            if($intVendor != $oldVendor || $intCategory != $oldCategory || $intChannel != $oldChannel) {
                $getVendor = PaymentVendor::findOne($model->payment_vendor_id);
                $getCategory = PaymentCategories::findOne($model->payment_category_id);
                $getChannel = PaymentChannels::findOne($model->payment_channel_id);
                if(empty($getVendor) || empty($getCategory) || empty($getChannel)) {
                    Yii::$app->session->setFlash('error', 'Vendor/Category/Channel not found.');
                    return $this->redirect(['update-account', 'id' => $model->id]);
                }
                $detailInfo['vendor']['id'] = $model->payment_vendor_id;
                $detailInfo['vendor']['name'] = $getVendor->name;
                $detailInfo['category']['id'] = $model->payment_category_id;
                $detailInfo['category']['name'] = $getCategory->name;
                $detailInfo['channel']['id'] = $model->payment_channel_id;
                $detailInfo['channel']['name'] = $getChannel->name;
                
                $model->detail_info = $detailInfo;
            }
            $json = stripslashes($_POST['PaymentAccounts']['detail_keys']);
            $data = json_decode($json, true);
            $model->detail_keys = $data;
            $model->save();
            Yii::$app->session->setFlash('success', 'Account updated successfully.');
            return $this->redirect(['view-account', 'id' => $model->id]);
        }

        $vendor = PaymentVendor::find()->where(['!=', 'status', PaymentVendor::STATUS_DELETED])->all();
        $vendorList = ArrayHelper::map($vendor, 'id', 'name');

        $category = PaymentCategories::find()->where(['!=', 'status', PaymentCategories::STATUS_DELETED])->all();
        $categoryList = ArrayHelper::map($category, 'id', 'name');

        $channel = PaymentChannels::find()->where(['!=', 'status', PaymentChannels::STATUS_DELETED])->all();
        $channelList = ArrayHelper::map($channel, 'id', 'name');

        return $this->render('update-account', [    
            'model' => $model,
            'vendorList' => $vendorList,
            'categoryList' => $categoryList,
            'channelList' => $channelList,
        ]);
    }

    public function actionSortAccount()
    {
        $allAccount = PaymentAccounts::find()->where(['!=', 'status', PaymentAccounts::STATUS_DELETED])->all();

        $arrayList = [];

        foreach($allAccount as $account) {
            $arrayList[$account->id] = ['content' => $account->name . ' | ' . $account->getStatusList()[$account->status]];
        }

        $formList = new PaymentAccounts();
        $formList->scenario = PaymentAccounts::SCENARIO_SORT;
        if ($this->request->isPost && $formList->load($this->request->post()) && $formList->validate()) {
            $array = explode(',', $formList->sortAccounts);
            $i = 1;
            $inputJson = [];
            foreach($array as $id) {
                $account = PaymentAccounts::findOne($id);
                $account->sort = $i;
                $account->save();
                $i++;
            }
            Yii::$app->session->setFlash('success', 'Account sorted successfully.');
            return $this->redirect(['account']);
        }

        return $this->render('sort-account', [
            'formList' => $formList,
            'arrayList' => $arrayList
        ]);
    }

    public function actionDeleteAccount($id)
    {
        $model = PaymentAccounts::findOne($id);
        $model->status = PaymentAccounts::STATUS_DELETED;
        $detailInfo = GlobalFunction::changeLogDelete($model->detail_info);
        $model->detail_info = $detailInfo;
        $model->save();
        Yii::$app->session->setFlash('success', 'Account deleted successfully.');
        return $this->redirect(['account']);
    }

    public function actionRestoreAccount($id)
    {
        $model = PaymentAccounts::findOne($id);
        if($model->status != PaymentAccounts::STATUS_DELETED) {
            Yii::$app->session->setFlash('error', 'Data not has been deleted.');
            return $this->redirect(['list-deleted-account']);
        }
        $model->status = PaymentAccounts::STATUS_INACTIVE;
        $detailInfo = GlobalFunction::changeLogRestore($model->detail_info);
        $model->detail_info = $detailInfo;
        $model->save();
        Yii::$app->session->setFlash('success', 'Account restored successfully.');
        return $this->redirect(['list-deleted-account']);
    }

    protected function findModelAccount($id)
    {
        if (($model = PaymentAccounts::find()->where(['id' => $id])->andWhere(['!=', 'status', PaymentAccounts::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

 
}