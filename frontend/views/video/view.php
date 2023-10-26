<?php

/** @var $this \yii\web\View */
/** @var $model \common\models\Video */
/** @var $similarVideos \common\models\Video[] */
/** @var $comments \common\models\Comment[] */

$this->title = $model->title . ' | ' . Yii::$app->name;
?>

<div class="row">
    <div class="col-sm-8">
        <div class="ratio ratio-16x9">
            <video class="embed-responsive" poster="<?= $model->getThumbnailLink() ?>"
                   src="<?= $model->getVideoLink() ?>" title="YouTube video" controls></video>
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
        <!-- channel begin -->
        <div>
            <p>
                <?= \common\helpers\Html::channelLink($model->createdBy) ?>
            </p>
            <?= \yii\helpers\Html::encode($model->description) ?>
        </div>
        <!-- channel end -->

        <!-- begin comment -->
        <div class="comments mt-5">
            <h4 class="mb-3"><span id="comment-count"><?= count($comments) ?></span> Comments</h4>
            <div class="create-comment mb-4">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img class="mr-3 comment-avatar" src="/image/avatar.svg" alt="Avatar Image">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <form id="create-comment-form" method="post"
                              action="<?= \yii\helpers\Url::to(['/comment/create']) ?>" data-pjax="1">
                            <input type="hidden" name="video_id" value="<?= $model->video_id ?>">
                            <textarea rows="1" id="leave-comment"
                                      class="form-control"
                                      name="comment"
                                      placeholder="Add a public comment..."></textarea>

                            <div class="action-buttons justify-content-end mt-2">
                                <button type="button" id="cancel-comment" class="btn btn-light">Cancel</button>
                                <button id="submit-comment" class="btn btn-primary">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="comments-wrapper" class="comments-wrapper">
                <?php foreach ($comments as $comment) {
                    echo $this->render('_comment_item', [
                        'model' => $comment
                    ]);
                } ?>
            </div>
        </div>
        <!-- end comment -->
    </div>
    <div class="col-sm-4">
        <?php foreach ($similarVideos as $similarVideo): ?>
            <div class="d-flex mb-3">
                <a href="<?= \yii\helpers\Url::to(['/video/view', 'id' => $similarVideo->video_id]) ?>">
                    <div class="ratio ratio-16x9 mr-2" style="width: 120px">
                        <video class="embed-responsive" poster="<?= $similarVideo->getThumbnailLink() ?>"
                               src="<?= $similarVideo->getVideoLink() ?>" title="YouTube video"></video>
                    </div>
                </a>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mt-0"><?= $similarVideo->title ?></h6>
                    <div class="text-muted">
                        <p class="m-0">
                            <?php echo \common\helpers\Html::channelLink($similarVideo->createdBy) ?>
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