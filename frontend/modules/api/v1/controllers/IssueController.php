<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\issue\GetIssuesByIdListIssue;
use frontend\modules\api\v1\models\issue\CreateNewIssue;

class IssueController extends ApiController
{
    public function actionIndex()
    {
        $model = new GetIssuesByIdListIssue();
        $model->setAttributes(Yii::$app->request->get());

        if ($result = $model->getIssues()) {
            return $this->sendResponse(self::STATUS_OK, $result);
        }
        
        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionCreate()
    {
        return $this->createEntity(new CreateNewIssue());
    }
}