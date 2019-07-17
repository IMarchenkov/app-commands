<?php

namespace api\modules\v1\controllers;

use yii\rest\Controller;

abstract class ApiController extends Controller
{
    protected const MESSAGE_ERROR_SERVER = 'При выполнении операции на сервере возникли проблемы.';
    protected const STATUS_OK = 1;
    protected const STATUS_ERROR = 0;

    protected function sendResponse($status, $message = '')
    {
        return [
            'status' => $status,
            'payload' => [
                'message' => $message,
            ],
        ];
    }
}
