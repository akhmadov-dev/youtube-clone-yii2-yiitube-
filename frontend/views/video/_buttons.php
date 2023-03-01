<?php
/** @var $model common\models\Video */
?>

    <!--Like button start-->
<?= \yii\bootstrap5\Html::a(
    '<i class="fa-solid fa-thumbs-up"></i> ' . $model->getLikes()->count(),
    \yii\helpers\Url::to(['/video/like', 'id' => $model->video_id]),
    [
        'class' => 'btn btn-sm ' . ($model->isLikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary'),
        'data-method' => 'post',
        'data-pjax' => '1'
    ]
) ?>

    <!--Dislike button start-->
<?= \yii\bootstrap5\Html::a(
    '<i class="fa-solid fa-thumbs-down"></i> ' . $model->getDislikes()->count(),
    \yii\helpers\Url::to(['/video/dislike', 'id' => $model->video_id]),
    [
        'class' => 'btn btn-sm ' . ($model->isDislikedBy(Yii::$app->user->id) ? 'btn-outline-primary' : 'btn-outline-secondary'),
        'data-method' => 'post',
        'data-pjax' => '1'
    ]
) ?>