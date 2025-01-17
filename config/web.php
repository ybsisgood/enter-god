<?php
$params = YII_ENV_DEV ? require __DIR__ . '/params_local.php': require __DIR__ . '/params.php';
$db = YII_ENV_DEV ? require __DIR__ . '/db_local.php': require __DIR__ . '/db.php';
$dbsso = YII_ENV_DEV ? require __DIR__ . '/db_sso_local.php': require __DIR__ . '/db_sso.php';
$dbedc = YII_ENV_DEV ? require __DIR__ . '/db_edc_local.php': require __DIR__ . '/db_edc.php';

$config = [
    'id' => 'basic'.$params['code-id'],
    'name' => $params['name'],
    'charset' => 'utf-8',
    'language' => $params['language'],
    'timeZone' => $params['timeZone'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','maintenanceMode'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules'=>[
        'user-management' => [
            'class' => 'ybsisgood\modules\UserManagement\UserManagementModule',
            'on beforeAction'=>function(yii\base\ActionEvent $event) {
                    if ( $event->action->uniqueId == 'user-management/auth/login' )
                    {
                        $event->action->controller->layout = 'loginLayout.php';
                    };
                },
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'markdown' => [
            'class' => 'kartik\markdown\Module',
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'G6ukP8IvMhO76_3Tw6eqvfn2K3UHAlJ4',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'ybsisgood\modules\UserManagement\components\UserConfig',
    
            // Comment this if you don't want to record user logins
            'on afterLogin' => function($event) {
                    \ybsisgood\modules\UserManagement\models\UserVisitLog::newVisitor($event->identity->id);
                }
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'db' => $db,
        'db_sso' => $dbsso,
        'db_edc' => $dbedc,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                'apps/view/<seo_url:[\w\-]+>' => 'apps/view',
                'apps/update/<seo_url:[\w\-]+>' => 'apps/update',
                'apps/roles/<seo_url:[\w\-]+>' => 'apps/roles',
                'apps/view-roles/<id:\d+>/<code_roles:[\w\-]+>' => 'apps/view-roles',
                'apps/update-roles/<id:\d+>/<code_roles:[\w\-]+>' => 'apps/update-roles',
                'apps/setting-role-permission/<id:\d+>/<code_roles:[\w\-]+>' => 'apps/setting-role-permission',
                'apps/permission-groups/<seo_url:[\w\-]+>' => 'apps/permission-groups',
                'apps/view-permission-groups/<id:\d+>/<code_permission_groups:[\w\-]+>' => 'apps/view-permission-groups',
                'apps/update-permission-groups/<id:\d+>/<code_permission_groups:[\w\-]+>' => 'apps/update-permission-groups',
                'apps/permissions/<seo_url:[\w\-]+>' => 'apps/permissions',
                'apps/view-permissions/<id:\d+>/<code_permissions:[\w\-]+>' => 'apps/view-permissions',
                'apps/update-permissions/<id:\d+>/<code_permissions:[\w\-]+>' => 'apps/update-permissions',
                // 'gallery/view/<seo_url:[\w\-]+>' => 'gallery/view', // contoh
                
            ],
        ],
        'maintenanceMode' => [ 
            'class' => 'app\components\MaintenanceMode',
        ],
        'globalfunction' => [
            'class' => 'app\components\GlobalFunction',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
