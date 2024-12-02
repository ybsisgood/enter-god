<?php

use yii\helpers\Url;

$baseUrl = Url::base();
$logoutUrl = Url::toRoute(['site/logout']);

?>

<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?= $baseUrl; ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?= $baseUrl ?>/themes/skote/assets/images/<?= Yii::$app->params['themeLogoSmallDark'] ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= $baseUrl ?>/themes/skote/assets/images/<?= Yii::$app->params['themeLogoLargeDark'] ?>" alt="" height="35">
                    </span>
                </a>

                <a href="<?= $baseUrl; ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= $baseUrl ?>/themes/skote/assets/images/<?= Yii::$app->params['themeLogoSmallLight'] ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= $baseUrl ?>/themes/skote/assets/images/<?= Yii::$app->params['themeLogoLargeLight'] ?>" alt="" height="35">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <!-- <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="bx bx-search-alt"></span>
                </div>
            </form> -->

            <!-- <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                    <span key="t-megamenu">Mega Menu</span>
                    <i class="mdi mdi-chevron-down"></i> 
                </button>
                <div class="dropdown-menu dropdown-megamenu">
                    <div class="row">
                        <div class="col-sm-8">
    
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="font-size-14" key="t-ui-components">UI Components</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="javascript:void(0);" key="t-lightbox">Lightbox</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-range-slider">Range Slider</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-sweet-alert">Sweet Alert</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-rating">Rating</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-forms">Forms</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-tables">Tables</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-charts">Charts</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <h5 class="font-size-14" key="t-applications">Applications</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="javascript:void(0);" key="t-ecommerce">Ecommerce</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-calendar">Calendar</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-email">Email</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-projects">Projects</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-tasks">Tasks</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-contacts">Contacts</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <h5 class="font-size-14" key="t-extra-pages">Extra Pages</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="javascript:void(0);" key="t-light-sidebar">Light Sidebar</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-compact-sidebar">Compact Sidebar</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-horizontal">Horizontal layout</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-maintenance">Maintenance</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-coming-soon">Coming Soon</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-timeline">Timeline</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-faqs">FAQs</a>
                                        </li>
                            
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 class="font-size-14" key="t-ui-components">UI Components</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="javascript:void(0);" key="t-lightbox">Lightbox</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-range-slider">Range Slider</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-sweet-alert">Sweet Alert</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-rating">Rating</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-forms">Forms</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-tables">Tables</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" key="t-charts">Charts</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-sm-5">
                                    <div>
                                        <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/megamenu-img.png" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->
        </div>

        <div class="d-flex">

            <!-- <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
        
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                    if (!empty($_SESSION['lang'])) {
                        $language = $_SESSION['lang'];
                        if ($language == "en") {
                            $imgPath = $baseUrl.'/themes/skote/assets/images/flags/us.jpg';
                        } elseif ($language == "sp") {
                            $imgPath = $baseUrl.'/themes/skote/assets/images/flags/spain.jpg';
                        } elseif ($language == "gr") {
                            $imgPath = $baseUrl.'/themes/skote/assets/images/flags/germany.jpg';
                        } elseif ($language == "it") {
                            $imgPath = $baseUrl.'/themes/skote/assets/images/flags/italy.jpg';
                        } elseif ($language == "ru") {
                            $imgPath = $baseUrl.'/themes/skote/assets/images/flags/russia.jpg';
                        } else {
                            $imgPath = $baseUrl.'/themes/skote/assets/images/flags/us.jpg';
                        }
                    } else {
                        $imgPath = $baseUrl.'/themes/skote/assets/images/flags/us.jpg';
                    }
                ?>
                    <img id="header-lang-img" src="<?php echo $imgPath; ?>" alt="Header Language" height="16">
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <a href="?lang=en" class="dropdown-item notify-item language" data-lang="en">
                        <img src="<?php echo $baseUrl; ?>/themes/skote/assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
                    </a>

                    <a href="?lang=sp" class="dropdown-item notify-item language" data-lang="sp">
                        <img src="<?php echo $baseUrl; ?>/themes/skote/assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <a href="?lang=gr" class="dropdown-item notify-item language" data-lang="gr">
                        <img src="<?php echo $baseUrl; ?>/themes/skote/assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                    </a>

                    <a href="?lang=it" class="dropdown-item notify-item language" data-lang="it">
                        <img src="<?php echo $baseUrl; ?>/themes/skote/assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <a href="?lang=ru" class="dropdown-item notify-item language" data-lang="ru">
                        <img src="<?php echo $baseUrl; ?>/themes/skote/assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                    </a>
                </div>
            </div>

            <!-- <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-customize"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="px-lg-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/brands/github.png" alt="Github">
                                    <span>GitHub</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/brands/bitbucket.png" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/brands/dribbble.png" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/brands/dropbox.png" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                    <span>Mail Chimp</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/brands/slack.png" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <!-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    <span class="badge bg-danger rounded-pill">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0" key="t-notifications"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small" key="t-view-all"> View All</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" key="t-your-order">Your order is placed</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/users/avatar-3.jpg"
                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-simplified">It will seem like simplified English.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" key="t-shipped">Your item is shipped</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="<?php # echo $baseUrl; ?>/themes/skote/assets/images/users/avatar-4.jpg"
                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Salena Layfield</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-occidental">As a skeptical Cambridge friend of mine occidental.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span> 
                        </a>
                    </div>
                </div>
            </div> -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?= $baseUrl ?>/themes/skote/assets/images/users/<?= Yii::$app->user->identity->avatar ?? 'user-dummy-img.jpg' ?>"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-<?= Yii::$app->user->identity->username ?? 'Guest' ?>"><?= Yii::$app->user->identity->username ?? 'Guest' ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    <!-- <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a>
                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a> -->
                    <a class="dropdown-item" href="<?= Url::toRoute(['/user-management/auth/change-own-password']) ?>"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-change-password">Change Password</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?= Url::toRoute(['/user-management/auth/logout']) ?>" ><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div>

        </div>
    </div>
</header>

<?php
$baseUrlEncoded = json_encode($baseUrl);
$scriptLanguage = <<<JS
(function ($) {

    'use strict';

    var language = localStorage.getItem('language');
    // Default Language
    var default_lang = 'en';

    function setLanguage(lang) {
        var baseUrl = $baseUrlEncoded;
        if (document.getElementById("header-lang-img")) {
            if (lang == 'en') {
                document.getElementById("header-lang-img").src = baseUrl + "/themes/skote/assets/images/flags/us.jpg";
            } else if (lang == 'sp') {
                document.getElementById("header-lang-img").src = baseUrl + "/themes/skote/assets/images/flags/spain.jpg";
            }
            else if (lang == 'gr') {
                document.getElementById("header-lang-img").src = baseUrl + "/themes/skote/assets/images/flags/germany.jpg";
            }
            else if (lang == 'it') {
                document.getElementById("header-lang-img").src = baseUrl + "/themes/skote/assets/images/flags/italy.jpg";
            }
            else if (lang == 'ru') {
                document.getElementById("header-lang-img").src = baseUrl + "/themes/skote/assets/images/flags/russia.jpg";
            }
            localStorage.setItem('language', lang);
            language = localStorage.getItem('language');
            getLanguage();
        }
    }

    // Multi language setting
    function getLanguage() {
        var baseUrl = $baseUrlEncoded;
        (language == null) ? setLanguage(default_lang) : false;
        $.getJSON(baseUrl + '/themes/skote/assets/lang/' + language + '.json', function (lang) {
            $('html').attr('lang', language);
            $.each(lang, function (index, val) {
                (index === 'head') ? $(document).attr("title", val['title']) : false;
                $("[key='" + index + "']").text(val);
            });
        });
    }

    function initLanguage() {
        // Auto Loader
        if (language != null && language !== default_lang)
            setLanguage(language);
        $('.language').on('click', function (e) {
            setLanguage($(this).attr('data-lang'));
        });
    }

    function init() {
    initLanguage();
    }

    init();

})(jQuery);
JS;

$this->registerJs($scriptLanguage, yii\web\View::POS_END);

?>