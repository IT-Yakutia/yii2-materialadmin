<?php

namespace ityakutia\materialadmin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use ityakutia\materialadmin\models\Profile;
use common\models\LoginForm;

/**
 * Class ProfileController
 * @package backend\controllers
 */
class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['logout', 'change', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['change', 'index'],
                        'allow' => false,
                        'roles' => ['doNotChangeCredentials'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Profile();
        $model->scenario = Profile::SCENARIO_PROFILE;
        $user = Yii::$app->user->identity;
        $model->loadFromItem(Yii::$app->user->identity);

        $load = $model->load(Yii::$app->request->post());

        if ($load && $model->edit($user)) {
            $model->loadFromItem(Yii::$app->user->identity);
            return $this->render('index', [
                'model' => $model,
                'success' => true,
            ]);
        }

        return $this->render('index', [
            'model' => $model,
            'success' => false,
        ]);
    }

    public function actionChange()
    {
        $model = new Profile();
        $model->scenario = Profile::SCENARIO_PWD;
        $user = Yii::$app->user->identity;
        $model->loadFromItem(Yii::$app->user->identity);

        $post = Yii::$app->request->post();
        $load = $model->load($post);

        if ($load && $model->repwd($user)) {
            $model->loadFromItem(Yii::$app->user->identity);
            return $this->render('change', [
                'model' => $model,
                'success_pwd' => true,
            ]);
        }

        return $this->render('change', [
            'model' => $model,
            'success_pwd' => false,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'empty';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}