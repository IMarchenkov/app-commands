<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/verifyEmail', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Привет, <?= Html::encode($user->login) ?>,</p>

    <p>Для подтверждения своего email перейдите по ссылке:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
