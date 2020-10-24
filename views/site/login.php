<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>
    <script type="text/javascript">
        VK.init({apiId: 7638372});
    </script>

    <!-- VK Widget -->
    <div id="vk_auth"></div>
    <script type="text/javascript">
        VK.Widgets.Auth("vk_auth", {"authUrl":"/auth/login-vk"});
    </script>
</div>
