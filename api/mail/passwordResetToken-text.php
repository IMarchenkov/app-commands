<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = 
    Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/resetPassword', 'token' => $user->password_reset_token]);
?>
Привет, <?= $user->login ?>,

Перейдите по ссылке ниже для того, чтобы сбросить пароль:

<?= $resetLink ?>
