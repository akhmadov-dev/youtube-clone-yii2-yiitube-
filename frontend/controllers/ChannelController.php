<?php

namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;

class ChannelController extends Controller
{
    public function actionView(string $username)
    {
        $channel = $this->findChannel($username);

        return $this->render('view', [
            'channel' => $channel
        ]);
    }

    /**
     * Find Channel
     * @param string $username
     * @return \common\models\User
     * @throws \yii\web\NotFoundHttpException
     */
    public function findChannel(string $username): \common\models\User
    {
        $channel = User::findByUsername($username);

        if (!$channel) {
            throw new \yii\web\NotFoundHttpException("Channel does not exists");
        }

        return $channel;
    }
}