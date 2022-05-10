Material Admin module for Yii2
====================
Material Admin module for Yii2

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run
```sh
php composer.phar require --prefer-dist it-yakutia/yii2-materialadmin "*"
```
or add
```json
"it-yakutia/yii2-materialadmin": "*"
```
to the require section of your `composer.json` file.

Add Module and set `layoutPath` in set backend config `main.php`:
```php
return [
    ...
    'layoutPath' => '@vendor/it-yakutia/yii2-materialadmin/src/views/layouts',
    ...
    'modules' => [
        ...
        'materialadmin' => \ityakutia\materialadmin\Module::class,
        ...
    ],
    ...
];
```

Add key to `controllerMap` section and add value in `controllerMap` `migration` section in console config `main.php`:
```php
return [
    ...
    'controllerMap' => [
        ...
	    'faker' => [
		    'class' => \ityakutia\materialadmin\commands\FakerController::class,
	    ],
        ...
        'migrate' => [
		    'class' => \yii\console\controllers\MigrateController::class,
		    'migrationPath' => [
				'@console/migrations',
				...
			    '@ityakutia/materialadmin/migrations',
			    ...
		    ],
	    ],
	    ...
    ],
    ...
];
```

create your custom navitems for `@backend/views/layout/_sidenav.php`:
```php
<?php

use yii\helpers\Url;

?>

<?php if(Yii::$app->user->can("costom_modules")) { ?>
    <li><a class="subheader grey-text"><i class="material-icons grey-text tiny">public</i> <?= Yii::t('app', 'Мои модули')?></a></li>
<?php } ?>

<?php if(Yii::$app->user->can("costom_module")) { ?>
    <li class="<?= (Yii::$app->controller->module->id=='costom_module' && Yii::$app->controller->id=='back')?'active':''; ?>"><a class="waves-effect waves-teal" href="<?= Url::toRoute('/costom_module/back/index') ?>"><i class="material-icons">pageview</i> <?= Yii::t('app', 'Мой модуль') ?></a></li>
<?php } ?>
```

Usage
-----

Use this `SiteController` for `backend`:

```php
/**
 * Site controller
 */
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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
     * @inheritdoc
     */
	public function actions()
	{
		return [
			'error' => [
				'class' => \yii\web\ErrorAction::class,
				'layout' => 'empty'
			],
		];
	}

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->redirect(['/materialadmin/profile/login']);
    }

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
}
```