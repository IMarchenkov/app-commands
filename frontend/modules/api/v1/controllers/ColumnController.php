<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\column\CreateNewColumn;
use frontend\modules\api\v1\models\column\UpdateColumn;
use frontend\modules\api\v1\models\column\ChangePositionColumn;

class ColumnController extends ApiController
{
    public function actionCreate()
    {
        return $this->createNewEntity(new CreateNewColumn());
    }

    public function actionUpdate($id)
    {
        return $this->doActionByEntity(new UpdateColumn($id));
    }

    public function actionChangePosition() {
        return $this->doActionByEntity(new ChangePositionColumn());
    }
}
