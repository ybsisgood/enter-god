<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\Maintenance;

class MaintenanceMode extends Component
{
    public function init()
    {
        parent::init();
        $maintenance = Maintenance::find()->one();
        
        if ($maintenance && $maintenance->status == 1) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_HTML;
            $title = Yii::$app->params['name'];
            $supportEmail = Yii::$app->params['supportEmail'];
            $baseUrl = Yii::$app->request->baseUrl;
            $response->data = <<<HTML
                <!doctype html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>{$title} | Maintenance</title>
                    <link href="themes/skote/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
                    <link href="themes/skote/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
                    <link href="themes/skote/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
                    <script>
                        !function ($) {
                        "use strict";
                        if (window.localStorage) {
                            var alreadyVisited = localStorage.getItem("is_visited");
                            var baseUrl = "{$baseUrl}";
                            if (alreadyVisited) {
                                switch (alreadyVisited) {
                                    case "light-mode-switch":
                                        document.documentElement.removeAttribute("dir");
                                        if (document.getElementById("bootstrap-style").getAttribute("href") != baseUrl + "/themes/skote/assets/css/bootstrap.min.css")
                                            document.getElementById("bootstrap-style").setAttribute("href", baseUrl + "/themes/skote/assets/css/bootstrap.min.css");
                                        if (document.getElementById("app-style").getAttribute("href") != baseUrl + "/themes/skote/assets/css/app.min.css")
                                            document.getElementById("app-style").setAttribute("href", baseUrl + "/themes/skote/assets/css/app.min.css");
                                        document.documentElement.setAttribute("data-bs-theme", "light");
                                        break;
                                    case "dark-mode-switch":
                                        document.documentElement.removeAttribute("dir");
                                        if (document.getElementById("bootstrap-style").getAttribute("href") != baseUrl + "/themes/skote/assets/css/bootstrap.min.css")
                                            document.getElementById("bootstrap-style").setAttribute("href", baseUrl + "/themes/skote/assets/css/bootstrap.min.css");
                                        if (document.getElementById("app-style").getAttribute("href") != baseUrl + "/themes/skote/assets/css/app.min.css")
                                            document.getElementById("app-style").setAttribute("href", baseUrl + "/themes/skote/assets/css/app.min.css");
                                        document.documentElement.setAttribute("data-bs-theme", "dark");
                                        break;
                                    case "rtl-mode-switch":
                                        if (document.getElementById("bootstrap-style").getAttribute("href") != baseUrl + "/themes/skote/assets/css/bootstrap-rtl.min.css")
                                            document.getElementById("bootstrap-style").setAttribute("href", baseUrl + "/themes/skote/assets/css/bootstrap-rtl.min.css");
                                        if (document.getElementById("app-style").getAttribute("href") != baseUrl + "/themes/skote/assets/css/app-rtl.min.css")
                                            document.getElementById("app-style").setAttribute("href", baseUrl + "/themes/skote/assets/css/app-rtl.min.css");
                                        document.documentElement.setAttribute("dir", "rtl");
                                        document.documentElement.setAttribute("data-bs-theme", "light");
                                        break;
                                    case "dark-rtl-mode-switch":
                                        if (document.getElementById("bootstrap-style").getAttribute("href") != baseUrl + "/themes/skote/assets/css/bootstrap-rtl.min.css")
                                            document.getElementById("bootstrap-style").setAttribute("href", baseUrl + "/themes/skote/assets/css/bootstrap-rtl.min.css");
                                        if (document.getElementById("app-style").getAttribute("href") != baseUrl + "/themes/skote/assets/css/app-rtl.min.css")
                                            document.getElementById("app-style").setAttribute("href", baseUrl + "/themes/skote/assets/css/app-rtl.min.css");
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
                </head>

                <body>
                    <div class="home-btn d-none d-sm-block">
                        <a href="{$baseUrl}" class="text-dark"><i class="fas fa-home h2"></i></a>
                    </div>
                    <section class="my-5 pt-sm-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="home-wrapper">
                                        <div class="mb-5">
                                            <a href="{$baseUrl}" class="d-block auth-logo">
                                                <img src="themes/skote/assets/images/logo-dark.png" alt="" height="20"
                                                    class="auth-logo-dark mx-auto">
                                                <img src="themes/skote/assets/images/logo-light.png" alt="" height="20"
                                                    class="auth-logo-light mx-auto">
                                            </a>
                                        </div>


                                        <div class="row justify-content-center">
                                            <div class="col-sm-4">
                                                <div class="maintenance-img">
                                                    <img src="themes/skote/assets/images/maintenance.svg" alt="" class="img-fluid mx-auto d-block">
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="mt-5">Site is Under Maintenance</h3>
                                        <p>Please check back in sometime.</p>

                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="card mt-4 maintenance-box">
                                                    <div class="card-body">
                                                        <i class="bx bx-envelope mb-4 h1 text-primary"></i>
                                                        <h5 class="font-size-15 text-uppercase">
                                                            Do you need Support?</h5>
                                                        <p class="text-muted mb-0">We apologize for any inconvenience this may cause and appreciate your understanding. If you have any questions or need assistance, please reach out to our support team at <a
                                                                href="mailto:{$supportEmail}"
                                                                class="text-decoration-underline">{$supportEmail}</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </body>

                </html>
            HTML;
            $response->send();
            exit;
        }
    }
}