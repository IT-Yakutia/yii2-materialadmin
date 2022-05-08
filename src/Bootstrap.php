<?php

namespace ityakutia\materialadmin;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
	    if ($app instanceof \yii\console\Application) {
			/** For console only */
			$app->controllerMap['faker'] = [
			    'class' => \ityakutia\materialadmin\commands\FakerController::class,
		    ];

		    if (empty($app->controllerMap['migrate'])) {
			    $app->controllerMap['migrate'] = [
				    'class' => \yii\console\controllers\MigrateController::class
			    ];
		    }

		    if (empty($app->controllerMap['migrate']['migrationPath'])) {
			    $app->controllerMap['migrate']['migrationPath'] = ['@console/migrations'];
		    }

		    $app->controllerMap['migrate']['migrationPath'] = array_merge(
			    $app->controllerMap['migrate']['migrationPath'],
			    ['@ityakutia/materialadmin/migrations']
		    );
	    }

		if (
			$app instanceof \yii\console\Application
			|| $app->id == 'backend'
		) {
			/** For backend and console  */
			if (empty($app->components['authManager'])) {
				$app->setComponents([
					'authManager' => [
						'class' => \yii\rbac\DbManager::class
					]
				]);
			}
		}

		if ($app->id == 'backend') {
			/** For backend only */
			$app->setModule('materialadmin', \ityakutia\materialadmin\Module::class);

			$app->layoutPath = '@vendor/it-yakutia/yii2-materialadmin/src/views/layouts';
		}
    }
}
