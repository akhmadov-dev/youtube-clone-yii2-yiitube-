<?php

namespace frontend\controllers;

use common\models\Subscribe;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
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
        ]);
    }

    /**
     * Channel view 
     * @param string $username 
     * @return string
     */
    public function actionView(string $username)
    {
        $channel = $this->findChannel($username);

        $dataProvider = new ActiveDataProvider([
            'query' => \common\models\Video::find()->creator($channel->id)->published()
        ]);

        return $this->render('view', [
            'channel' => $channel,
            'dataProvider' => $dataProvider
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

            // send email
            \Yii::$app->mailer->compose([
                'html' => 'subscriber-html', 'text' => 'subscriber-text'
            ], [
                'channel' => $channel,
                'user' => \Yii::$app->user->identity
            ])
                ->setFrom(\Yii::$app->params['senderEmail'])
                ->setTo($channel->email)
                ->setSubject('You have new subscriber')
                ->send();
        } else {
            $subscriber->delete();
        }

        return $this->renderAjax('_subscribe', [
            'channel' => $channel
        ]);
    }
}
