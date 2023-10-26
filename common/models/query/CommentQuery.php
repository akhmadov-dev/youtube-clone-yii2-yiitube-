<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Comment]].
 *
 * @see \common\models\Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param string $videoId
     * @return CommentQuery
     */
    public function videoId(string $videoId): CommentQuery
    {
        return $this->andWhere(['video_id' => $videoId]);
    }

    /**
     * @return CommentQuery
     */
    public function latest(): CommentQuery
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }
}
