<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Video $model */
/** @var yii\bootstrap5\ActiveForm $form */

\backend\assets\TagsInputAsset::register($this);
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-md-8">

            <?= $form->errorSummary($model) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<!--            <div class="form-group">-->
<!--                <label class="form-label" for="thumbnail">--><?php //= $model->getAttributeLabel('thumbnail') ?><!--</label>-->
<!--                <div class="input-group mb-3">-->
<!--                    <input type="file" class="form-control" id="thumbnail" name="thumbnail">-->
<!--                    <label class="input-group-text" for="thumbnail">Upload</label>-->
<!--                </div>-->
<!--            </div>-->

            <?= $form->field($model, 'thumbnail')->fileInput() ?>

            <?= $form->field($model, 'tags', [
                    'inputOptions' => ['data-role' => 'tagsinput']
            ])->textInput(['maxlength' => true, [
                    'multiple' => true
            ]]) ?>

        </div>
        <div class="col-md-4">

            <div class="ratio ratio-16x9 mb-3">
                <video class="embed-responsive"
                       poster="<?= $model->getThumbnailLink() ?>"
                       src="<?= $model->getVideoLink() ?>"
                       title="YouTube video" controls></video>
            </div>

            <div class="mb-3">
                <div class="text-muted">Video Link</div>
                <?= Html::a('Open Video', $model->getVideoLink()) ?>
            </div>

            <div class="mb-3">
                <div class="text-muted">Video Name</div>
                <?= $model->video_name ?>
            </div>

            <?= $form->field($model, 'status')->dropDownList($model->getStatusLabels()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
