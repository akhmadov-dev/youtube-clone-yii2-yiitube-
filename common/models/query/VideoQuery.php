<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Video]].
 *
 * @see \common\models\Video
 */
class VideoQuery extends \yii\db\ActiveQuery
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public function active()
    {
        return $this->andWhere('[[status]]=' . self::STATUS_ACTIVE);
    }

    public function inActive()
    {
        return $this->andWhere('[[status]]=' . self::STATUS_INACTIVE);
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
