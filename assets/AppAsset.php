<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'themes/default/css/site.css',
    ];
    public $js = [
        [
            'themes/skote/assets/libs/jquery/jquery.min.js', 
            'position' => \yii\web\View::POS_HEAD
        ],
        'themes/skote/assets/libs/bootstrap/js/bootstrap.bundle.min.js',
        'themes/skote/assets/libs/metismenu/metisMenu.min.js',
        'themes/skote/assets/libs/simplebar/simplebar.min.js',
        'themes/skote/assets/libs/node-waves/waves.min.js',
        // 'themes/custom/custom_css.css',

        'themes/skote/assets/js/app.js',
        'themes/skote/assets/libs/sweetalert2/sweetalert2.all.min.js',
        'themes/custom/disable_submit.js',
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap5\BootstrapAsset'
    ];
}
