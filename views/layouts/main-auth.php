<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

$baseUrl = Url::base();

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/themes/icon/favicon.ico')]);
$this->registerMetaTag(['name' => 'robots', 'content' => Yii::$app->params['robotTxt'] ?? '']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-layout-width="boxed" data-topbar="dark" data-preloader="disable" data-card-layout="borderless" data-bs-theme="light" data-topbar-image="pattern-1">
<head>
    <title><?= Yii::$app->params['name'] ?> <?= Html::encode($this->title) ? ' | ' . Html::encode($this->title) : ''  ?></title>
    <link href="<?= $baseUrl;?>/themes/skote/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="<?= $baseUrl;?>/themes/skote/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $baseUrl;?>/themes/skote/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <script>
        !function ($) {
            "use strict";
            if (window.localStorage) {
                var alreadyVisited = localStorage.getItem("is_visited");
                if (alreadyVisited) {
                    switch (alreadyVisited) {
                        case "light-mode-switch":
                            document.documentElement.removeAttribute("dir");
                            if (document.getElementById("bootstrap-style").getAttribute("href") != "<?= $baseUrl;?>/themes/skote/assets/css/bootstrap.min.css")
                                document.getElementById("bootstrap-style").setAttribute("href", "<?= $baseUrl;?>/themes/skote/assets/css/bootstrap.min.css");
                            if (document.getElementById("app-style").getAttribute("href") != "<?= $baseUrl;?>/themes/skote/assets/css/app.min.css")
                                document.getElementById("app-style").setAttribute("href", "<?= $baseUrl;?>/themes/skote/assets/css/app.min.css");
                            document.documentElement.setAttribute("data-bs-theme", "light");
                            break;
                        case "dark-mode-switch":
                            document.documentElement.removeAttribute("dir");
                            if (document.getElementById("bootstrap-style").getAttribute("href") != "<?= $baseUrl;?>/themes/skote/assets/css/bootstrap.min.css")
                                document.getElementById("bootstrap-style").setAttribute("href", "<?= $baseUrl;?>/themes/skote/assets/css/bootstrap.min.css");
                            if (document.getElementById("app-style").getAttribute("href") != "<?= $baseUrl;?>/themes/skote/assets/css/app.min.css")
                                document.getElementById("app-style").setAttribute("href", "<?= $baseUrl;?>/themes/skote/assets/css/app.min.css");
                            document.documentElement.setAttribute("data-bs-theme", "dark");
                            break;
                        case "rtl-mode-switch":
                            if (document.getElementById("bootstrap-style").getAttribute("href") != "<?= $baseUrl;?>/themes/skote/assets/css/bootstrap-rtl.min.css")
                                document.getElementById("bootstrap-style").setAttribute("href", "<?= $baseUrl;?>/themes/skote/assets/css/bootstrap-rtl.min.css");
                            if (document.getElementById("app-style").getAttribute("href") != "<?= $baseUrl;?>/themes/skote/assets/css/app-rtl.min.css")
                                document.getElementById("app-style").setAttribute("href", "<?= $baseUrl;?>/themes/skote/assets/css/app-rtl.min.css");
                            document.documentElement.setAttribute("dir", "rtl");
                            document.documentElement.setAttribute("data-bs-theme", "light");
                            break;
                        case "dark-rtl-mode-switch":
                            if (document.getElementById("bootstrap-style").getAttribute("href") != "<?= $baseUrl;?>/themes/skote/assets/css/bootstrap-rtl.min.css")
                                document.getElementById("bootstrap-style").setAttribute("href", "<?= $baseUrl;?>/themes/skote/assets/css/bootstrap-rtl.min.css");
                            if (document.getElementById("app-style").getAttribute("href") != "<?= $baseUrl;?>/themes/skote/assets/css/app-rtl.min.css")
                                document.getElementById("app-style").setAttribute("href", "<?= $baseUrl;?>/themes/skote/assets/css/app-rtl.min.css");
                            document.documentElement.setAttribute("dir", "rtl");
                            document.documentElement.setAttribute("data-bs-theme", "dark");
                            break;
                        default:
                            console.log("Something wrong with the layout mode.");
                    }
                }
            }
        }(window.jQuery);
    </script>
    <?php $this->head() ?>
</head>
<body data-sidebar="dark">
<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
