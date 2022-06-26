<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ityakutia\materialadmin\assets\MaterialAdminAsset;
use uraankhayayaal\materializecomponents\checkbox\WCheckbox;

$adminBundle = MaterialAdminAsset::register($this);

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;

$isCustomLoginLogo = isset(Yii::$app->params['materialadmin_module']) ? isset(Yii::$app->params['materialadmin_module']['custom_assets']) ? isset(Yii::$app->params['materialadmin_module']['custom_assets']['logo_login']) : false : false;
$customLoginLogoPath = $isCustomLoginLogo ? Yii::$app->params['materialadmin_module']['custom_assets']['logo_login'] : null;

?>
<div class="site-login">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <h1 class="white-text center-align" title="<?= Html::encode($this->title) ?>"><img src="<?= $isCustomLoginLogo ? $customLoginLogoPath : ($adminBundle->baseUrl.'/img/logo_nav.png'); ?>" alt="Управление сайтом" style="vertical-align: middle; max-width: 100%;"></h1>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="card-panel z-depth-5">
                <h5 class="center-align">Вход в админку</h5>
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'style' => 'padding: 0 10px; width: calc(100% - 20px);']) ?>
                    <?= $form->field($model, 'password')->passwordInput(['style' => 'padding: 0 10px; width: calc(100% - 20px);']) ?>
                    <?= WCheckbox::widget(['model' => $model, 'attribute' => 'rememberMe']); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
