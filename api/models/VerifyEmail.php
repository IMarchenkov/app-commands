<?php

namespace api\models;

use common\models\User;

class VerifyEmail extends ValidationModel
{
    public $token;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['token', 'required', 'message' => 'Токен не может быть пустым.'],
            ['token', 'validateToken'],
        ];
    }

    public function validateToken($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = User::findByVerificationToken($this->token);
            if (!$this->_user) {
                $this->addError($attribute, 'Неверный токен.');
            }
        }
    }

    public function verifyEmail()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        return $user->save(false) ? $user : null;
    }
}
