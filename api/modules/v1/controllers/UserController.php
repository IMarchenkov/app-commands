<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\models\User;

class UserController extends ActiveController {
    public $modelClass = User::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);

        return $actions;
    }

    public function actionIndex()
    {
        return [
            'status'=> 'OK'
        ];
    }
}