<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = $title;
?>
        <h2><?= $title ?></h2>
        <div class="chat">
            <?php Pjax::begin(); ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_mes',
                'summary'=> false,
                'emptyText' => 'Нет скрытых сообщений',
            ]) ?>
            <?php Pjax::end(); ?>
        </div>

