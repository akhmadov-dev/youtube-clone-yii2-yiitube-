<?php

namespace frontend\controllers;

use common\models\Comment;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ResponseFormatterInterface;

class CommentController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'content' => [
                'class' => ContentNegotiator::class,
                'only' => ['create'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post']
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        $comment = new Comment();

        if ($comment->load(\Yii::$app->request->post(), '') && $comment->save()) {
            $commentData = $comment->toArray();
            unset($commentData['created_by'], $commentData['video_id']);
            $commentData['created_at'] = \Yii::$app->formatter->asRelativeTime($commentData['created_at']);
            $commentData['user'] = $comment->createdBy->toArray();

            return [
                'success' => true,
                'comment' => $commentData
            ];
        }

        return [
            'success' => false,
            'errors' => $comment->errors,
        ];
    }

}