<?php

namespace frontend\controllers;

use common\models\Subscribe;
use common\models\User;
use yii\web\Controller;

class ChannelController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['suscribe'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            // 'verb' => [
            //     'class' => VerbFilter::class,
            //     'actions' => [
            //         'like' => ['post'],
            //         'dislike' => ['post'],
            //     ]
            // ]
        ]);
    }
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

    /**
     * Subscribe
     * @param string $username 
     * @return string
     */
    public function actionSubscribe(string $username)
    {
        $channel = $this->findChannel($username);

        $userId = \Yii::$app->user->id;
        $subscriber = $channel->isSubscribed($userId);

        if (!$subscriber) {
            $subscriber = new Subscribe();
            $subscriber->channel_id = $channel->id;
            $subscriber->user_id = $userId;
            $subscriber->create_at = time();
            $subscriber->save();
        } else {
            $subscriber->delete();
        }

        return $this->renderAjax('_subscribe', [
            'channel' => $channel
        ]);
    }
}
