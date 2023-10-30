<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\Video;
use common\models\VideoLike;
use common\models\VideoView;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class VideoController extends Controller
{
    /**
     * Behaviors
     * @return array
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['like', 'dislike', 'history'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post'],
                ]
            ]
        ]);
    }

    public function actionIndex()
    {
        $this->layout = 'main';
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()
                ->with('createdBy')
                ->published()
                ->latest(),
            'pagination' => [
                'pageSize' => 5
            ]
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
        $video = $this->findVideo($id);

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

        $similarVideos = Video::find()
            ->published()
            ->andWhere(['NOT', ['video_id' => $id]])
            ->byKeyword($video->title)
            ->limit(10)
            ->all();

        $comments = Comment::find()
            ->with(['createdBy', 'video'])
            ->videoId($id)
            ->latest()
            ->all();

        return $this->render('view', [
            'model' => $video,
            'comments' => $comments,
            'similarVideos' => $similarVideos
        ]);
    }

    /**
     * Like action
     * @param string $id
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionLike(string $id)
    {
        $video = $this->findVideo($id);
        $user_id = \Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()
            ->userIdVideoId($user_id, $id)
            ->one();

        if (!$videoLikeDislike) {
            $this->saveLikeDislike($id, $user_id, VideoLike::TYPE_LIKE);
        } elseif ($videoLikeDislike->type === VideoLike::TYPE_LIKE) {
            $videoLikeDislike->delete();
        } else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($id, $user_id, VideoLike::TYPE_LIKE);
        }

        return $this->renderAjax('_buttons', [
            'model' => $video
        ]);
    }

    /**
     * Dislike action
     * @param string $id
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDislike(string $id)
    {
        $video = $this->findVideo($id);
        $user_id = \Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()
            ->userIdVideoId($user_id, $id)
            ->one();
        if (!$videoLikeDislike) {
            $this->saveLikeDislike($id, $user_id, VideoLike::TYPE_DISLIKE);
        } elseif ($videoLikeDislike->type === VideoLike::TYPE_DISLIKE) {
            $videoLikeDislike->delete();
        } else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($id, $user_id, VideoLike::TYPE_DISLIKE);
        }

        return $this->renderAjax('_buttons', [
            'model' => $video
        ]);
    }

    public function actionSearch(string $keyword)
    {
        $this->layout = 'main';
        $query = Video::find()
            ->with('createdBy')
            ->published()
            ->latest();

        if ($keyword) {
            $query->byKeyword($keyword);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return string
     */
    public function actionHistory(): string
    {
        $this->layout = 'main';
        $query = Video::find()
            ->alias('v')
            ->innerJoin("(SELECT video_id, MAX(created_at) as max_date 
                    FROM video_view
                    WHERE user_id = :userId 
                    GROUP BY video_id) vv", "vv.video_id = v.video_id", [
                'userId' => \Yii::$app->user->id
            ])
            ->orderBy("vv.max_date DESC");

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param string $id Video id
     * @return Video
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findVideo(string $id): Video
    {
        $video = Video::findOne($id);

        if (!$video) {
            throw new \yii\web\NotFoundHttpException("Video does not exit");
        }

        return $video;
    }

    protected function saveLikeDislike(string $video_id, int $user_id, int $type)
    {
        $videoLikeDislike = new VideoLike();
        $videoLikeDislike->video_id = $video_id;
        $videoLikeDislike->user_id = $user_id;
        $videoLikeDislike->type = $type;
        $videoLikeDislike->created_at = time();
        $videoLikeDislike->save();
    }
}
