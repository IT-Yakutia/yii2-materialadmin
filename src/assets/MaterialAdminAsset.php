<?php

namespace ityakutia\materialadmin\assets;

class MaterialAdminAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@ityakutia/materialadmin/assets/src/';

    public $css = [
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'css/materialize.min.css',
        'css/admin.css',
    ];
    public $js = [
        'js/materialize.min.js',
        // 'js/sortable.min.js',
        'js/admin.js',
    ];
    public $depends = [
        \yii\web\YiiAsset::class,
    ];
}