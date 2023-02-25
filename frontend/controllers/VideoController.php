<?php

namespace frontend\controllers;

use common\models\Video;
use common\models\VideoView;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class VideoController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->published()->latest()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param string $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(string $id)
    {
        $this->layout = 'auth';
        $video = Video::findOne($id);

        if (!$video) {
            throw new \yii\web\NotFoundHttpException("Video does not exit");
        }

        /**
         * Bitta user uchun bir vaqtda bir necha marta video view
         * yozilmasligi uchun
         * !VideoView::findOne(['user_id' => \Yii::$app->user->id, 'created_at' => time()])
         * ushbu code bilan tekshirilsa ham bo'ladi
         */
        $videoView = new VideoView();
        $videoView->video_id = $id;
        $videoView->user_id = \Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();

        return $this->render('view', [
            'model' => $video
        ]);
    }
}