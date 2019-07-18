<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = 
    Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/resetPassword', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Привет, <?= Html::encode($user->login) ?>,</p>

    <p>Перейдите по ссылке ниже для того, чтобы сбросить пароль:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
