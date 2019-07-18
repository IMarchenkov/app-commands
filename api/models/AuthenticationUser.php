<?php
namespace api\models;

use Yii;
use common\models\User;

/**
 * Login form
 */
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
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Некорректный логин или пароль.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            Yii::$app->response->headers->set('Authorization', 'Bearer ' . $this->getUser()->access_token);
            return true;
        }
        
        return false;
    }

    private function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByLogin($this->login);
        }

        return $this->_user;
    }
}
