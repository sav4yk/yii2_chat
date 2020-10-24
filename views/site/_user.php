<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
Yii::$app->formatter->locale = 'ru-RU';
if (Html::encode($model->isAdmin)) {
    $role = 'Админ';
} else {
    $role = 'Пользователь';
}
?>
<div class="message">
    <div class="ava"><img src="<?= $model->photo ?>"/></div>
    <div>
        <div class="title"><?= Html::encode($model->fullname) ?>:</div>

        <div class="text"><?= $role ?></div>
        <?= Html::beginForm(['site/change-role', 'uid' => $model->uid], 'post' ) ?>
        <?= Html::submitButton('Изменить роль', ['class' => 'submit']) ?>
        <?= Html::endForm() ?>
    </div>


</div>
