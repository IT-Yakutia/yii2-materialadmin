<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use ityakutia\materialadmin\assets\MaterialAdminAsset;

$adminBundle = MaterialAdminAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title>IT Yakutia Administration</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $adminBundle->baseUrl; ?>/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $adminBundle->baseUrl; ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $adminBundle->baseUrl; ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $adminBundle->baseUrl; ?>/favicon/site.webmanifest">
    <?php $this->head() ?>
</head>
<body class="login ">
<?php $this->beginBody() ?>

    <main>
        <div class="container">
            <?= $content ?>
        </div>
    </main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
