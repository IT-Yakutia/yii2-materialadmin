<?php

namespace ityakutia\materialadmin\assets;

use yii\web\AssetBundle;

class MaterialAdminAsset extends AssetBundle
{
    public $sourcePath = '@ityakutia/materialadmin/assets/src/';

    public $css = [
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'css/materialize.min.css',
        'css/admin.css',
    ];
    public $js = [
        'js/jquery.lazy.min.js',
        'js/materialize.min.js',
        // 'js/sortable.min.js',
        'js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
