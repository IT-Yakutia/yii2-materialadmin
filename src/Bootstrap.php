<?php


namespace ityakutia\materialadmin;


use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->setModule('materialadmin', 'ityakutia\materialadmin\Module');
    }
}
