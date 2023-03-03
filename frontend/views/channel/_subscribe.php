<?php

/** @var $channel \common\models\User */
// echo '<pre>';
// var_dump($channel->isSubscribed(\Yii::$app->user->id));exit;
?>

<?= \yii\helpers\Html::a(
    'Subscribe <i class="far fa-bell"></i>',
    \yii\helpers\Url::to(['/channel/subscribe', 'username' => $channel->username]),
    [
        'class' => 'btn ' . ($channel->isSubscribed(\Yii::$app->user->id) == null ? 'btn-secondary' : 'btn-danger'),
        'role' => 'button',
        'data-method' => 'post',
        'data-pjax' => "1"
    ]
) ?> <?= $channel->getSubscribers()->count() ?>
