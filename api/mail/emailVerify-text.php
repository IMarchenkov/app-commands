<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/verifyEmail', 'token' => $user->verification_token]);
?>
Привет <?= $user->login ?>,

Для подтверждения своего email перейдите по ссылке:

<?= $verifyLink ?>
