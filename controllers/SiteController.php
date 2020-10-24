<?php

namespace app\controllers;

use app\models\Chat;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage with chat.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) {
            $dataProvider = new ActiveDataProvider([
                'query' => Chat::find()->orderBy('created_at DESC'),
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Chat::find()->where(['visible'=>1])->orderBy('created_at DESC'),
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'title' => 'Простой чат'
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays login page.
     *
     * @return string
     */
    public function actionLogin()
    {
        return $this->render('login');
    }

    /**
     * Creates a new Chat model.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chat();
        $model->message = Yii::$app->request->post('message');
        $model->user_id = Yii::$app->user->getId();
        if ($model->validate() && $model->save()) {
            Yii::$app->session->setFlash('success', "Сообщение отправлено");
        } else
        Yii::$app->session->setFlash('error', "Нельзя отправлять пустое сообщение");
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Chat model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionSetVisible($id)
    {
        if (($model = Chat::findOne($id)) !== null) {
            $model->setVisible();
        }
        return $this->redirect(['/']);
    }

    /**
     * Displays homepage with hide messages
     *
     * @return string
     */
    public function actionGetHide()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Chat::find()->where(['visible'=>0])->orderBy('created_at DESC'),
        ]);
        return $this->render('index_hide', [
            'dataProvider' => $dataProvider,
            'title' => 'Скрытые сообщения'
        ]);
    }

    /**
     * Displays users list.
     *
     * @return string
     */
    public function actionUsers()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->orderBy('id'),
        ]);
        return $this->render('users', [
            'dataProvider' => $dataProvider,
            'title' => 'Пользователи'
        ]);
    }

    /**
     * Change user role
     *
     * @return string
     */
    public function actionChangeRole($uid)
    {
        if (($model = User::findOne(['uid' => $uid])) !== null) {
            $model->changeRole();
        }
        return $this->redirect(['site/users']);
    }
}
