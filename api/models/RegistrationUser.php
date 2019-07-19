<?php

namespace api\models;

use Yii;
use common\models\User;

class RegistrationUser extends ValidationModel
{
    public $login;
    public $email;
    public $password;

    private const VIEW_EMAIL_REGISTRATION = 'emailVerify';
    private const SUBJECT_EMAIL_REGISTRATION = 'Account registration at ';

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

        $user = CreateNewUser::createUser($this);
        return $user && 
            SendEmailUser::sendEmail(self::VIEW_EMAIL_REGISTRATION, $user, self::SUBJECT_EMAIL_REGISTRATION);
    }
}
