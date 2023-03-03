<?php

/** @var \common\models\Video  $model */
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

    </div>
</div>