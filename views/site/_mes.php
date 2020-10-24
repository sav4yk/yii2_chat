<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
Yii::$app->formatter->locale = 'ru-RU';
?>
<div class="message <?= (Html::encode($model->user->isAdmin)) ? 'admin' : '' ?>">
    <div class="ava"><img src="<?= $model->user->photo ?>"/></div>
    <?php if (!Yii::$app->user->isGuest): ?>
    <?php if(Html::encode(Yii::$app->user->identity->isAdmin)): ?>
        <?php if($model->visible): ?>
        <?= Html::a(
        '<span class="glyphicon glyphicon-eye-open pull-right"></span>',
        ['/site/set-visible', 'id' => $model->id]) ?>
        <?php else: ?>
            <?= Html::a(
                '<span class="glyphicon glyphicon-eye-close pull-right"></span>',
                ['/site/set-visible', 'id' => $model->id]) ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
    <div>
        <div class="title"><?= Html::encode($model->user->fullname) ?> <?= Yii::$app->formatter->asDate($model->created_at, 'php: d.m.Y'); ?> написал(а):</div>
        <div class="text"><?= Html::encode($model->message) ?></div>
    </div>


</div>
