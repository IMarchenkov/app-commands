<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\User;
use common\models\RegistrationUser;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);

        return $actions;
    }

    public function actionCreate()
    {
        return [
            'status' => 'OK',
        ];
    }

    public function actionIndex()
    {
        $login = Yii::$app->request->post('login');
        $password = Yii::$app->request->post('password');
        $email = Yii::$app->request->post('email');

        $user = new RegistrationUser();
        $user->login = $login;
        $user->password = $password;
        $user->email = $email;
        
        //$isRegistration = $user->signup();

        if (!$user->signup()) {
            return [
                'response' => 'error',
                'message' => $user->getErrorMessage()
            ];
        }

        return [
            'response' => 'ok',
        ];
    }
}
