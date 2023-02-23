<?php

use yii\grid\SerialColumn;
use common\models\Video;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var Video $model */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Video', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => SerialColumn::class],
            [
                'attribute' => 'video_id',
                'content' => function ($model) {
                    return $this->render('_video_item', ['model' => $model]);
                }
            ],
            [
                'attribute' => 'status',
                'content' => static function (Video $model) {
                    return $model->getStatusLabels()[$model->status];
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => ActionColumn::class,
                'urlCreator' => static function ($action, Video $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'video_id' => $model->video_id]);
                }
            ],
        ],
    ]) ?>


</div>
