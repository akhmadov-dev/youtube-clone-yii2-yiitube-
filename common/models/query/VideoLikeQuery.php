<?php

namespace common\models\query;

use common\models\VideoLike;

/**
 * This is the ActiveQuery class for [[\common\models\VideoLike]].
 *
 * @see \common\models\VideoLike
 */
class VideoLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\VideoLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\VideoLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Filter videId and userId
     * @param $userId
     * @param $videoId
     * @return $this the query object itself
     */
    public function userIdVideoId($userId, $videoId)
    {
        return $this->andWhere([
            'video_id' => $videoId,
            'user_id' => $userId
        ]);
    }

    /**
     * Liked filter
     * @return $this
     */
    public function liked()
    {
        return $this->andWhere(['type' => \common\models\VideoLike::TYPE_LIKE]);
    }

    /**
     * Disliked filter
     * @return $this
     */
    public function disliked()
    {
        return $this->andWhere(['type' => \common\models\VideoLike::TYPE_DISLIKE]);
    }
}
