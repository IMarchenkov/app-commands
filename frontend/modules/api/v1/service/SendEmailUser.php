<?php

namespace frontend\modules\api\v1\service;

use Yii;
use common\models\User;

class SendEmailUser
{
    /**
     * Send email user
     *
     * @param string $viewEmail
     * @param User $user
     * @param string $subjectEmail
     * @return bool whether message is sent successfully.
     */
    public static function sendEmail($viewEmail, $user,  $subjectEmail, $email = "")
    {
        if ($email == "") 
            $email = $user->email;
            
        /*return Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewEmail . '-html', 'text' => $viewEmail . '-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject($subjectEmail . Yii::$app->name)
            ->send();*/

        return Yii::$app
            ->sendGrid
            ->compose(
                ['html' => $viewEmail . '-html', 'text' => $viewEmail . '-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject($subjectEmail . Yii::$app->name)
            ->send();
    }
}
