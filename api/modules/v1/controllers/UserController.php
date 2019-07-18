<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use api\models\RegistrationUser;
use api\models\VerifyEmail;
use api\models\AuthenticationUser;
use api\models\RecoveryPasswordUser;
use api\models\ResetPasswordUser;

class UserController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            //'except' => ['create', 'verify-email', 'auth', 'recovery'],
            'only' => ['index', 'update'],
        ];

        return $behaviors;
    }

    public function actionUpdate()
    {
        return $this->sendResponse(self::STATUS_OK);
    }

    public function actionIndex()
    {
        //return $this->sendResponse(self::STATUS_OK, Yii::$app->user->identity);
        $user = Yii::$app->user->identity;
        return $this->sendResponse(self::STATUS_OK, $user);
    }

    public function actionCreate()
    {
        $model = new RegistrationUser(Yii::$app->request->post());

        if ($model->signup()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionVerifyEmail()
    {
        $model = new VerifyEmail(Yii::$app->request->post());

        if ($model->verifyEmail()) {
            return $this->sendResponse(self::STATUS_OK, $model);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionAuth()
    {
        $model = new AuthenticationUser(Yii::$app->request->post());

        if ($model->login()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionRecovery()
    {
        $model = new RecoveryPasswordUser(Yii::$app->request->post());

        if ($model->recoveryPassword()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionResetPassword()
    {
        $model = new ResetPasswordUser(Yii::$app->request->post());

        if ($model->resetPassword()) {
            return $this->sendResponse(self::STATUS_OK, $model->resetPassword());
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    private function getMessage($model)
    {
        $errorValidation = $model->getErrorMessage();

        return $errorValidation ? $errorValidation : self::MESSAGE_ERROR_SERVER;
    }
}
