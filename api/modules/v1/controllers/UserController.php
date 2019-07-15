<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\models\User;

class UserController extends ActiveController {
    public $modelClass = User::class;
}