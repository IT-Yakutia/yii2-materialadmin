<?php

use yii\db\Migration;

/**
 * Class m220624_130835_add_dont_change_credentials_tbl
 */
class m220624_130835_add_dont_change_credentials_tbl extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $doNotChangeCredentials = $auth->getPermission('doNotChangeCredentials');
        if($doNotChangeCredentials == null){
            $doNotChangeCredentials = $auth->createPermission('doNotChangeCredentials');
            $doNotChangeCredentials->description = 'Запрет к изменению данных для доступа';

            $auth->add($doNotChangeCredentials);
        }
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $doNotChangeCredentials = $auth->getPermission('doNotChangeCredentials');
        if($doNotChangeCredentials !== null)
            $auth->remove($doNotChangeCredentials);
        
    }
}
