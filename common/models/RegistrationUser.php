<?php

namespace common\models;

use Yii;
use yii\base\Model;

class RegistrationUser extends Model
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
            ['login', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Данный логин уже используется.'],
            ['login', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Данный email уже используется.'],

            ['password', 'required', 'message' => 'Пароль не может быть пустым.'],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль должен содержать как минимум 6 символов.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
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

    public function getErrorMessage() {
        $arrayErrors = [];
        foreach ($this->getErrors() as $key => $error) {
            foreach ($error as $errorMessage) {
                $arrayErrors[$key] = $errorMessage;
            }
        }

        return $arrayErrors;
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
