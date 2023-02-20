<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Video $model */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>

        <div class="upload-icon">
            <i class="fa-solid fa-upload"></i>
        </div>
        <p>Drag and drop a file you want to upload</p>
        <p class="text-muted">Your video will be private until you publish it</p>
    </div>

</div>
