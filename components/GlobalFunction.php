<?php

namespace app\components;

use Yii;
use yii\base\Component;
use ybsisgood\modules\UserManagement\models\User;
use app\models\LogActivity;
use ybsisgood\helpers\LittleBigHelper;
use Ikimea\Browser\Browser;
/**
 * This is the model class for table "maintenance".
 *
 * @property int $id
 * @property int $status
 * @property string|null $message
 */
class GlobalFunction extends Component {

    public function getUserName($id) {
        $user = User::find()->where(['id' => $id])->one();
        if (!$user) {
            return 'Unknown';
        }
        return $user->username;
    }

    public static function changeLogCreate()
    {
        $detailInfo = [];
        $detailInfo['change_log']['created_at'] = gmdate("Y-m-d\TH:i:s\Z");
        $detailInfo['change_log']['created_by'] = Yii::$app->user->identity->username;
        $detailInfo['change_log']['updated_at'] = null;
        $detailInfo['change_log']['updated_by'] = null;
        $detailInfo['change_log']['deleted_at'] = null;
        $detailInfo['change_log']['deleted_by'] = null;
        return $detailInfo;
    }

    public static function changeLogUpdate($dataInfo)
    {
        $detailInfo = $dataInfo;
        $detailInfo['change_log']['updated_at'] = gmdate("Y-m-d\TH:i:s\Z");
        $detailInfo['change_log']['updated_by'] = Yii::$app->user->identity->username;
        return $detailInfo;
    }

    public static function changeLogDelete($dataInfo)
    {
        $detailInfo = $dataInfo;
        $detailInfo['change_log']['deleted_at'] = gmdate("Y-m-d\TH:i:s\Z");
        $detailInfo['change_log']['deleted_by'] = Yii::$app->user->identity->username;
        return $detailInfo;
    }

    public static function changeLogRestore($dataInfo)
    {   
        $detailInfo = $dataInfo;
        $detailInfo['change_log']['deleted_at'] = null;
        $detailInfo['change_log']['deleted_by'] = null;
        $detailInfo['change_log']['updated_at'] = gmdate("Y-m-d\TH:i:s\Z");
        $detailInfo['change_log']['updated_by'] = Yii::$app->user->identity->username;
        $detailInfo['change_log']['already_restore'] = true;
        return $detailInfo;
    }

    public static function addLogActivity($table = null, $action = '') {
        $browser = new Browser();
        
        $newLog = new LogActivity();
        $newLog->tables_name = $table;
        $newLog->description = $action;
        $newLog->created_at = date('Y-m-d H:i:s');
        $newLog->user_id = Yii::$app->user->identity->id;
        $detailInfo = [];
        $detailInfo['user']['ip'] = LittleBigHelper::getRealIp();
        $detailInfo['user']['agent'] = $browser->getUserAgent();
        $detailInfo['user']['os'] = $browser->getPlatform();
        $detailInfo['user']['browser'] = $browser->getBrowser();
        $detailInfo['user']['language'] = isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : '';
        $newLog->detail_info = $detailInfo;
        $newLog->save();

        return true;
    }

    
    public function getDateTime($time) {
        return date('H:i:s - d M Y', strtotime($time));
    }

    public static function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

}