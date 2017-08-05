<?php

namespace app\classes;

use Yii;
use yii\base\Behavior;
use app\classes\Caption;
use yii\db\ActiveRecord;

class SetFlashCRUD extends Behavior {

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterCreate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            // ActiveRecord::EVENT_BEFORE_DELETE => 'checkRelatedModels',
            //http://mypc.su/proverka-sushestvovaniya-svyazanih-modeley/
        ];
    }

    public function afterDelete() {

        // Yii::$app->getSession()->setFlash('delete-success', Caption::FLASH_DELETE_SUCCESS);
    }

    public function afterCreate() {

        //Yii::$app->getSession()->setFlash('create-success', Caption::FLASH_CREATE_SUCCESS);
    }

    public function afterUpdate() {

        //Yii::$app->getSession()->setFlash('update-success', Caption::FLASH_UPDATE_SUCCESS);
    }

}
