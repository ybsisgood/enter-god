<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
            <h5 class="m-0 me-2">Settings</h5>

            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />
        <h6 class="text-center mb-0">Choose Layouts</h6>

        <div class="p-4">
            <div class="mb-2">
                <img src="<?= $baseUrl; ?>/themes/skote/assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                <label class="form-check-label" for="light-mode-switch">Light Mode</label>
            </div>
    
            <div class="mb-2">
                <img src="<?= $baseUrl; ?>/themes/skote/assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
            </div>
    
            <div class="mb-2">
                <img src="<?= $baseUrl; ?>/themes/skote/assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
            </div>

            <div class="mb-2">
                <img src="<?= $baseUrl; ?>/themes/skote/assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
            </div>
            <div class="form-check form-switch mb-5">
                <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
            </div>

            
        </div>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<?php 
$baseUrlEncoded = json_encode($baseUrl);
$scriptThemes = <<<JS

(function ($) {
    'use strict';
    function initSettings() {
        if (window.localStorage) {
            var alreadyVisited = localStorage.getItem("is_visited");
            if (!alreadyVisited) {
                if ($('html').attr('dir') === 'rtl' && $('html').attr('data-bs-theme') === 'dark') {
                    $("#dark-rtl-mode-switch").prop('checked', true);
                    $("#light-mode-switch").prop('checked', false);  
                    localStorage.setItem("is_visited", "dark-rtl-mode-switch");
                    updateThemeSetting(alreadyVisited);
                }else if ($('html').attr('dir') === 'rtl') {
                    $("#rtl-mode-switch").prop('checked', true);
                    $("#light-mode-switch").prop('checked', false);
                    localStorage.setItem("is_visited", "rtl-mode-switch");
                    updateThemeSetting(alreadyVisited);
                }else if ($('html').attr('data-bs-theme') === 'dark') {
                    $("#dark-mode-switch").prop('checked', true);
                    $("#light-mode-switch").prop('checked', false);
                    localStorage.setItem("is_visited", "dark-mode-switch");
                    updateThemeSetting(alreadyVisited);
                } else {
                    localStorage.setItem("is_visited", "light-mode-switch");
                }
            } else {
                $(".right-bar input:checkbox").prop('checked', false);
                $("#" + alreadyVisited).prop('checked', true);
            }
        }
        $("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch, #dark-rtl-mode-switch").on("change", function (e) {
            updateThemeSetting(e.target.id);
        });

        // show password input value
        $("#password-addon").on('click', function () {
            if ($(this).siblings('input').length > 0) {
                $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
            }
        })
    }

    function updateThemeSetting(id) {
        var baseUrl = $baseUrlEncoded;
        if ($("#light-mode-switch").prop("checked") == true && id === "light-mode-switch") {
            $("html").removeAttr("dir");
            $("#dark-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            if($("#bootstrap-style").attr('href') != baseUrl + '/themes/skote/assets/css/bootstrap.min.css')
                $("#bootstrap-style").attr('href', baseUrl + '/themes/skote/assets/css/bootstrap.min.css');
            $('html').attr('data-bs-theme', 'light');
            if($("#app-style").attr('href') != baseUrl + '/themes/skote/assets/css/app.min.css')
            $("#app-style").attr('href', baseUrl + '/themes/skote/assets/css/app.min.css');
            localStorage.setItem("is_visited", "light-mode-switch");
        } else if ($("#dark-mode-switch").prop("checked") == true && id === "dark-mode-switch") {
            $("html").removeAttr("dir");
            $("#light-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            $('html').attr('data-bs-theme', 'dark');
            if($("#bootstrap-style").attr('href') != baseUrl + '/themes/skote/assets/css/bootstrap.min.css')
                $("#bootstrap-style").attr('href', baseUrl + '/themes/skote/assets/css/bootstrap.min.css');
            if($("#app-style").attr('href') != baseUrl + '/themes/skote/assets/css/app.min.css')
                $("#app-style").attr('href', baseUrl + '/themes/skote/assets/css/app.min.css');
                localStorage.setItem("is_visited", "dark-mode-switch");
        } else if ($("#rtl-mode-switch").prop("checked") == true && id === "rtl-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            $("#dark-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            if($("#bootstrap-style").attr('href') != baseUrl + '/themes/skote/assets/css/bootstrap-rtl.min.css')
                $("#bootstrap-style").attr('href', baseUrl + '/themes/skote/assets/css/bootstrap-rtl.min.css');
            if($("#app-style").attr('href') != baseUrl + '/themes/skote/assets/css/app-rtl.min.css')
                $("#app-style").attr('href', baseUrl + '/themes/skote/assets/css/app-rtl.min.css');
            $("html").attr("dir", 'rtl');
            $('html').attr('data-bs-theme', 'light');
            localStorage.setItem("is_visited", "rtl-mode-switch");
        }
        else if ($("#dark-rtl-mode-switch").prop("checked") == true && id === "dark-rtl-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-mode-switch").prop("checked", false);
            if($("#bootstrap-style").attr('href') != baseUrl + '/themes/skote/assets/css/bootstrap-rtl.min.css')
                $("#bootstrap-style").attr('href', baseUrl + '/themes/skote/assets/css/bootstrap-rtl.min.css');
            if($("#app-style").attr('href') != baseUrl + '/themes/skote/assets/css/app-rtl.min.css')
                $("#app-style").attr('href', baseUrl + '/themes/skote/assets/css/app-rtl.min.css');
            $("html").attr("dir", 'rtl');
            $('html').attr('data-bs-theme', 'dark');
            localStorage.setItem("is_visited", "dark-rtl-mode-switch");
        }
    }

    function init() {
        
        initSettings();
    }

    init();
})(jQuery);

JS;
$this->registerJs($scriptThemes, yii\web\View::POS_END);
?>
