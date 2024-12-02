<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;
use yii\helpers\Url;

$baseUrl = Url::base();
$this->title = $name;
$fisrtCode = 999;
if (($errorCode = strpos($name, "#")) !== FALSE) {
    $fisrtCode = substr($name, $errorCode+1);
}

$code1 = substr($fisrtCode, 0, 1);
$code2 = substr($fisrtCode, 1, 1);
$code3 = substr($fisrtCode, 2, 1);

if($code2 == 0){
    $code2 = '<i class="bx bx-buoy bx-spin text-primary display-3"></i>';
}
if($code3 == 0){
    $code3 = '<i class="bx bx-buoy bx-spin text-primary display-3"></i>';
}

?>

<div class="account-pages my-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <h1 class="display-2 fw-medium">
                        <?= $code1.$code2.$code3 ?>
                    </h1>
                    <h4 class="text-uppercase"><?= nl2br(Html::encode($message)) ?></h4>
                    <div class="mt-5 text-center">
                        <a class="btn btn-primary waves-effect waves-light" href="<?= Url::home() ?>">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div>
                    <img src="<?= $baseUrl; ?>/themes/skote/assets/images/error-img.png" alt="<?= $name ?>" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
