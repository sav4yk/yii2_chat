<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = $title;
?>
        <h2><?= $title ?></h2>
        <div class="chat">
            <?php Pjax::begin(); ?>
            <?php if (!Yii::$app->user->isGuest): ?>
            <div class="message">
                <div class="ava"><img src="<?= Yii::$app->user->identity->photo ?>"/></div>
                <div>
                    <div class="title"><?= Yii::$app->user->identity->fullname ?> написал(а):</div>
                    <div class="text">
                        <?= Html::beginForm(['site/create'], 'post' ) ?>
                        <?= Html::textarea( 'message', '', ['class' => 'form-group']) ?>
                            <?= Html::submitButton('', ['class' => 'glyphicon glyphicon-pencil']) ?>
                        <?= Html::endForm() ?>
                    </div>
                </div>

            </div>
            <?php endif; ?>

            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_mes',
                'summary'=> false,
                'emptyText' => 'Пока нет сообщений',

            ]) ?>

            <?php Pjax::end(); ?>
        </div>

