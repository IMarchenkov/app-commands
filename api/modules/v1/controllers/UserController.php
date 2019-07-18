<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use api\models\RegistrationUser;
use api\models\VerifyEmail;
use api\models\AuthenticationUser;
use api\models\RecoveryPasswordUser;
use api\models\ResetPasswordUser;
use common\models\User;

class UserController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
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
        $user = Yii::$app->user->identity;
        $user->setScenario(User::SCENARIO_PROFILE);
        return $this->sendResponse(self::STATUS_OK, $user);
    }

    public function actionCreate()
    {
        $model = new RegistrationUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->signup()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionVerifyEmail()
    {
        $model = new VerifyEmail();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->verifyEmail()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionAuth()
    {
        $model = new AuthenticationUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->login()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionRecovery()
    {
        $model = new RecoveryPasswordUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->recoveryPassword()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionResetPassword()
    {
        $model = new ResetPasswordUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->resetPassword()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    private function getMessage($model)
    {
        $errorValidation = $model->getErrorMessage();

        return $errorValidation ? $errorValidation : self::MESSAGE_ERROR_SERVER;
    }
}
