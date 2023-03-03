<?php
/** @var $this \yii\web\View; */
/** @var $channel \common\models\User */
/** @var $dataProvider  \yii\data\ActiveDataProvider */
?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-4"><?= $channel->username ?></h1>
        <hr class="my-4">
        <?php \yii\widgets\Pjax::begin() ?>

        <?= $this->render('_subscribe', [
            'channel' => $channel
        ]) ?>

        <?php \yii\widgets\Pjax::end() ?>
    </div>
</div>


<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '@frontend/views/video/_video_item',
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]
]) ?>
