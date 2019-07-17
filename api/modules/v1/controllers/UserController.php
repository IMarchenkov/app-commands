<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use api\models\RegistrationUser;
use api\models\VerifyEmail;
use api\models\AuthorizationUser;

class UserController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['create', 'verify-email', 'auth'],
        ];

        return $behaviors;
    }

    public function actionUpdate()
    {
        return $this->sendResponse(self::STATUS_OK);
    }

    public function actionIndex()
    {
        return $this->sendResponse(self::STATUS_OK, Yii::$app->user->identity);
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
        $model = new AuthorizationUser(Yii::$app->request->post());

        if ($model->login()) {
            return $this->sendResponse(self::STATUS_OK, $model->login());
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    private function getMessage($model)
    {
        $errorValidation = $model->getErrorMessage();

        return $errorValidation ? $errorValidation : self::MESSAGE_ERROR_SERVER;
    }
}
