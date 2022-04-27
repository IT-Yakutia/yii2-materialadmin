<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Профиль';

?>
<div class="profile-index">
    <div class="row">
        <div class="col s12">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'errorCssClass' => 'red-text',
            ]); ?>

            <?= $form->field($model, 'username')->textInput() ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php

    $script = <<< JS
if($success)M.toast({html: 'Ваш профиль успешно изменен!'});
JS;
    $this->registerJs($script, yii\web\View::POS_READY);

    ?>
</div>
