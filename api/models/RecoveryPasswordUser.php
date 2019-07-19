<?php

namespace api\models;

use Yii;
use common\models\User;

class RecoveryPasswordUser extends ValidationModel
{
    public $email;

    private const VIEW_EMAIL_RECOVERY_PASSWORD = 'passwordResetToken';
    private const SUBJECT_EMAIL_RECOVERY_PASSWORD = 'Password reset for ';

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым.'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'validateEmail'],
        ];
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'email' => $this->email,
            ]);

            if (!$this->_user) {
                $this->addError($attribute, 'Не найдено ни одного пользователя с таким email.');
            }
        }
    }

    public function recoveryPassword()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;
        if (!User::checkPasswordResetToken($user)) {
            return false;
        }

        return SendEmailUser::sendEmail(self::VIEW_EMAIL_RECOVERY_PASSWORD, $user,      self::SUBJECT_EMAIL_RECOVERY_PASSWORD);
    }
}
