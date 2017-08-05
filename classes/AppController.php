<?php

namespace app\classes;

use Yii;
use yii\web\Controller;

/**
 * Общие настройки Контроллеров.
 */
class AppController extends Controller {

    /**
     * Является ли  текущий пользователь владельйем  записи?
     */
    protected function isUserOwner() {
        if ($this->findModel(Yii::$app->request->get('id'))
                ->user_id == Yii::$app->user->id) {
            return TRUE;
        } else {
            return FALSE;
        }
        return true;
    }

}
