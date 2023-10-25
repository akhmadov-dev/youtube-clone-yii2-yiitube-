<?php

/** @var $model \common\models\Video */
/** @var $similarVideos \common\models\Video[] */
?>

<div class="row">
    <div class="col-sm-8">
        <div class="ratio ratio-16x9">
            <video class="embed-responsive" poster="<?= $model->getThumbnailLink() ?>" src="<?= $model->getVideoLink() ?>" title="YouTube video" controls></video>
        </div>
        <h6 class="mt-2"><?= $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <?= $model->getViews()->count() ?> views . <?= \Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <?php \yii\widgets\Pjax::begin() ?>

                <?= $this->render('_buttons', [
                    'model' => $model
                ]) ?>

                <?php \yii\widgets\Pjax::end() ?>
            </div>
        </div>
        <div>
            <p>
                <?= \common\helpers\Html::channelLink($model->createdBy) ?>
            </p>
            <?= \yii\helpers\Html::encode($model->description) ?>
        </div>
    </div>
    <div class="col-sm-4">
        <?php foreach ($similarVideos as $similarVideo): ?>
            <div class="d-flex mb-3">
                <a href="<?= \yii\helpers\Url::to(['/video/view', 'id' => $similarVideo->video_id]) ?>">
                    <div class="ratio ratio-16x9 mr-2" style="width: 120px">
                        <video class="embed-responsive" poster="<?= $similarVideo->getThumbnailLink() ?>" src="<?= $similarVideo->getVideoLink() ?>" title="YouTube video"></video>
                    </div>
                </a>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0"><?= $similarVideo->title ?></h6>
                    <div class="text-muted">
                        <p class="m-0">
                            <?php echo \common\helpers\Html::channelLink($similarVideo->createdBy)  ?>
                        </p>
                        <small>
                            <?php echo $similarVideo->getViews()->count() ?> views .
                            <?php echo Yii::$app->formatter->asRelativeTime($similarVideo->created_at) ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>