<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Изменить пароль';

?>
<div class="profile-change">
    <div class="row">
        <div class="col s12">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'errorCssClass' => 'red-text',
            ]); ?>

            <?= $form->field($model, 'old_password')->passwordInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'password_repeat')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <?php

    $script = <<< JS
if($success_pwd)M.toast({html: 'Ваш пароль успешно изменен!'});
JS;
    $this->registerJs($script, yii\web\View::POS_READY);

    ?>
</div>
