<?php

namespace api\models;

use Yii;
use common\models\User;

class AuthenticationUser extends ValidationModel
{
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required', 'message' => 'Логин не может быть пустым.'],

            ['rememberMe', 'boolean'],

            ['password', 'required', 'message' => 'Пароль не может быть пустым.'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = User::findByLogin($this->login);
            if (!$this->_user || !$this->_user->validatePassword($this->password)) {
                $this->addError($attribute, 'Некорректный логин или пароль.');
            }
        }
    }

    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;
        if (!User::checkAccessToken($user)) {
            return false;
        }

        Yii::$app->response->headers->set('Authorization', 'Bearer '.$user->access_token);
        return true;
    }
}
