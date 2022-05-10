<?php

namespace ityakutia\materialadmin\controllers;

use ityakutia\materialadmin\models\Profile;
use common\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Class ProfileController
 * @package backend\controllers
 */
class ProfileController extends Controller
{
	/**
	 * @return array[]
	 */
    public function behaviors(): array
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
                        'actions' => ['login'],
                        'allow' => true
                    ],
                ],
            ],
	        'verbs' => [
		        'class' => VerbFilter::class,
		        'actions' => [
			        'logout' => ['post'],
		        ],
	        ],
        ];
    }

    /**
     * @return array
     */
    public function actions(): array
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
     * @return string|Response
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
     * @return string|Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}