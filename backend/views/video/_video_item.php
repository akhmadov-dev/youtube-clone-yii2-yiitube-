<?php
/** @var common\models\Video $model */
?>

<div class="d-flex" >
    <div class="flex-shrink-0" style="width: 120px">
        <a href="<?= \yii\helpers\Url::to(['/video/update', 'video_id' => $model->video_id]) ?>">
            <div class="ratio ratio-16x9 mr-2">
                <video class="embed-responsive"
                       poster="<?= $model->getThumbnailLink() ?>"
                       src="<?= $model->getVideoLink() ?>"></video>
            </div>
        </a>
    </div>
    <div class="flex-grow-1 ms-3" style="max-width: 200px">
        <h6 class="mt-0"><?= $model->title ?></h6>
        <?= \yii\helpers\StringHelper::truncate($model->description, 10) ?>
    </div>
</div>