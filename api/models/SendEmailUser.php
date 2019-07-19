<?php

namespace api\models;

use Yii;
use common\models\User;

class SendEmailUser
{
    /**
     * Send email to user.
     *
     * @param string $viewEmail
     * @param User   $user
     * @param string $subjectEmail
     *
     * @return bool whether this message is sent successfully.
     */
    public static function sendEmail($viewEmail, $user, $subjectEmail)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewEmail.'-html', 'text' => $viewEmail.'-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name.' robot'])
            ->setTo($user->email)
            ->setSubject($subjectEmail.Yii::$app->name)
            ->send();
    }
}
