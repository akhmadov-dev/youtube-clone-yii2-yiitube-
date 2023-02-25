<?php

namespace frontend\controllers;

use common\models\Video;
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

        return $this->render('view', [
            'model' => $video
        ]);
    }
}