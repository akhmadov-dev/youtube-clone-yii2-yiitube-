<?php
/** @var $model \common\models\Video */
?>

<div class="card m-3" style="width: 18rem;">
    <a href="<?= \yii\helpers\Url::to(['/video/view', 'id' => $model->video_id]) ?>">
        <div class="ratio ratio-16x9">
            <video class="embed-responsive"
                   poster="<?= $model->getThumbnailLink() ?>"
                   src="<?= $model->getVideoLink() ?>"
                   title="YouTube video"></video>
        </div>
    </a>

    <div class="card-body p-2">
        <h6 class="card-title m-0"><?= $model->title ?></h6>
        <p class="text-muted card-text m-0">
            <?= $model->createdBy->username ?>
        </p>
        <p class="text-muted card-text m-0">
            <?= $model->getViews()->count() ?> views . <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </p>
    </div>
</div>