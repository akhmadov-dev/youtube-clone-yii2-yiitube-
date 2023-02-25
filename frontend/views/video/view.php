<?php
/** @var $model \common\models\Video */
?>

<div class="row">
    <div class="col-sm-8">
        <div class="ratio ratio-16x9">
            <video class="embed-responsive"
                   poster="<?= $model->getThumbnailLink() ?>"
                   src="<?= $model->getVideoLink() ?>"
                   title="YouTube video"
                   controls></video>
        </div>
        <h6 class="mt-2"><?= $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                123 views . <?= \Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fa-solid fa-thumbs-up"></i> 9
                </button>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-thumbs-down"></i> 3
                </button>
            </div>
        </div>
    </div>
    <div class="col-sm-4">

    </div>
</div>
