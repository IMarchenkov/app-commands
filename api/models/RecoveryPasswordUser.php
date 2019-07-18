<?php
namespace api\models;

use Yii;
use common\models\User;

class RecoveryPasswordUser extends ValidationModel
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым.'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Не найдено ни одного пользователя с таким email.'
            ],
        ];
    }

    public function recoveryPassword()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return $this->sendEmail($user);
    }

    private function sendEmail($user)
    {
        return Yii::$app
        ->mailer
        ->compose(
            ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
            ['user' => $user]
        )
        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
        ->setTo($this->email)
        ->setSubject('Password reset for ' . Yii::$app->name)
        ->send();
    }
}
