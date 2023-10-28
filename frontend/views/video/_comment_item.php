<?php
/**
 * @var $model \common\models\Comment
 */

?>

<div class="d-flex mb-3 comment-item">
    <div class="flex-shrink-0">
        <img class="mr-3 comment-avatar" src="/image/avatar.svg" alt="Avatar Image">
    </div>
    <div class="flex-grow-1 ms-3">
        <h6 class="mt-0">
            <?= \common\helpers\Html::channelLink($model->createdBy) ?>
            <small class="text-muted"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></small>
        </h6>
        <div class="comment-text">
            <?= $model->comment ?>
            <div class="dropdown comment-actions">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-thumbtack"></i> Pin
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="button-action mt-2">
            <button class="btn btn-sm btn-light">
                REPLY
            </button>
        </div>
    </div>
</div>