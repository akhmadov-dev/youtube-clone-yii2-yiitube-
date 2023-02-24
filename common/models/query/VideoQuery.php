<?php

namespace common\models\query;

use common\models\Video;

/**
 * This is the ActiveQuery class for [[\common\models\Video]].
 *
 * @see \common\models\Video
 */
class VideoQuery extends \yii\db\ActiveQuery
{
    /**
     * @return VideoQuery
     */
    public function published()
    {
        return $this->andWhere('[[status]]=' . Video::STATUS_PUBLISHED);
    }

    /**
     * @return VideoQuery
     */
    public function unPublished()
    {
        return $this->andWhere('[[status]]=' . Video::STATUS_UNLISTED);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Video[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Video|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $user_id
     * @return VideoQuery
     */
    public function creator($user_id)
    {
        return $this->andWhere(['created_by' => $user_id]);
    }

    /**
     * @return VideoQuery
     */
    public function latest()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }
}
