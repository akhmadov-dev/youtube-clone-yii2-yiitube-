<?php

namespace frontend\controllers;

use common\models\Comment;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
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
                'only' => ['create', 'delete'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['POST'],
                    'delete' => ['POST']
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
            return [
                'success' => true,
                'comment' => $this->renderPartial('@frontend/views/video/_comment_item', [
                    'model' => $comment
                ])
            ];
        }

        return [
            'success' => false,
            'errors' => $comment->errors,
        ];
    }


    public function actionDelete(int $id)
    {
        $comment = $this->findModel($id);
        if ($comment->created_by === \Yii::$app->user->id) {
            $comment->delete();
            return ['success' => true];
        }
        throw new ForbiddenHttpException();
    }

    protected function findModel(int $id) {
        $comment = Comment::findOne(['id' => $id]);

        if (!$comment) {
            throw new NotFoundHttpException;
        }

        return $comment;
    }

}