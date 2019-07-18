<?php

namespace api\models;

use Yii;
use common\models\User;

class RegistrationUser extends ValidationModel
{
    public $login;
    public $email;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required', 'message' => 'Логин не может быть пустым.'],
            ['login', 'unique', 'targetClass' => User::class, 'message' => 'Данный логин уже используется.'],
            ['login', 'string', 'min' => 2, 'max' => 255, 'tooShort' => 'Логин должен содержать как минимум 2 символа.', 'tooLong' => 'Максимальная длина логина - 255 символов.'],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым.'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'string', 'max' => 255, 'tooLong' => 'Email может содержать максимум 255 символов.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Данный email уже используется.'],

            ['password', 'required', 'message' => 'Пароль не может быть пустым.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать как минимум 6 символов.'],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generateAccessToken();

        return $user->save() && $this->sendEmail($user);
    }

    private function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name.' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at '.Yii::$app->name)
            ->send();
    }
}
