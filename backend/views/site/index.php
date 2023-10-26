<?php

/** @var yii\web\View $this */
/** @var $latestVideo \common\models\Video */
/** @var $numberOfView integer */
/** @var $numberOfSubscribers integer */
/** @var $subscribers \common\models\Subscribe[] */

$this->title = 'My Yii Application';
?>
<div class="site-index d-flex">
    <div class="card m-2" style="width: 18rem;">
        <div class="ratio ratio-16x9 mb-3">
            <video class="embed-responsive"
                   poster="<?= $latestVideo->getThumbnailLink() ?>"
                   src="<?= $latestVideo->getVideoLink() ?>"
                   title="YouTube video"></video>
        </div>
        <div class="card-body">
            <h6 class="card-title"><?= $latestVideo->title ?></h6>
            <p class="card-text">
                Likes: <?= $latestVideo->getLikes()->count() ?> <br>
                Views: <?= $latestVideo->getViews()->count() ?>
            </p>
            <a href="<?= \yii\helpers\Url::to(['/video/update',
                'id' => $latestVideo->video_id]) ?>"
               class="btn btn-primary">Edit</a>
        </div>
    </div>
    <div class="card m-2" style="width: 18rem;">
        <div class="card-body">
            <h6 class="card-title">Total Views</h6>
            <p class="card-text" style="font-size: 48px">
               <?= $numberOfView ?>
            </p>
        </div>
    </div>
    <div class="card m-2" style="width: 18rem;">
        <div class="card-body">
            <h6 class="card-title">Total Subscribers</h6>
            <p class="card-text" style="font-size: 48px">
               <?= $numberOfSubscribers ?>
            </p>
        </div>
    </div>
    <div class="card m-2" style="width: 18rem;">
        <div class="card-body">
            <h6 class="card-title">Latest Subscribers</h6>
           <?php foreach ($subscribers as $subscriber): ?>
                <div>
                    <?= $subscriber->user->username ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
