<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/verifyNewEmail', 'token' => $user->verify_new_email_token]);
?>
<div class="verify-email">
    <p>Привет, <?= Html::encode($user->login) ?>,</p>

    <p>Для подтверждения своего нового email перейдите по ссылке:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
