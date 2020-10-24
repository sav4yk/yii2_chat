<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Login with VK API
     *
     * @param $uid
     * @param $first_name
     * @param $last_name
     * @param $photo
     * @param $hash
     * @return Response
     */
    public function actionLoginVk($uid, $first_name, $last_name, $photo, $hash)
    {
        $user = new User();
        if ($user->loginFromVk($uid, $first_name, $last_name, $photo, $hash)) {
            return $this->redirect(['site/index']);
        }
        return $this->redirect(['site/login']);
    }
}