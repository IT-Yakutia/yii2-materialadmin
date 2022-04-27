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
?>
<div class="site-login">
    <h1 class="white-text center-align" title="<?= Html::encode($this->title) ?>"><img src="<?= $adminBundle->baseUrl; ?>/img/logo_nav.png" width="500" alt="Управление сайтом" style="vertical-align: middle;"></h1>
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
