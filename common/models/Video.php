<?php

namespace common\models;

use Imagine\Image\Box;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\imagine\Image;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $status
 * @property int|null $has_thumbnail
 * @property string|null $video_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 * @property \common\models\VideoLike[] $likes
 * @property \common\models\VideoLike[] $dislikes
 */
class Video extends \yii\db\ActiveRecord
{
    public const STATUS_UNLISTED = 0;
    public const STATUS_PUBLISHED = 1;


    /**
     * @var \yii\web\UploadedFile
     */
    public $video;

    /**
     * @var \yii\web\UploadedFile
     */
    public $thumbnail;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%video}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['video_id'], 'unique'],
            [['video_id'], 'string', 'max' => 16],

            ['video', 'file', 'extensions' => ['mp4'], 'maxSize' => 1024 * 1024 * 500],

            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'tags', 'video_name'], 'string', 'max' => 512],

            ['thumbnail', 'image', 'minWidth' => 1280, 'maxSize' => 1024 * 1024 * 5],
            ['has_thumbnail', 'integer'],
            ['has_thumbnail', 'default', 'value' => 0],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_UNLISTED],

            ['created_by', 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumbnail' => 'Has Thumbnail',
            'video_name' => 'Video Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'thumbnail' => 'Thumbnail'
        ];
    }

    /**
     * get status labels
     * @return string[]
     */
    public function getStatusLabels(): array
    {
        return [
            self::STATUS_UNLISTED => 'Unlisted',
            self::STATUS_PUBLISHED => 'Published',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViews()
    {
        return $this->hasMany(VideoView::class, ['video_id' => 'video_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(VideoLike::class, ['video_id' => 'video_id'])
            ->liked();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDislikes()
    {
        return $this->hasMany(VideoLike::class, ['video_id' => 'video_id'])
            ->disliked();
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(static::class);
    }

    /**
     * @param $runValidation
     * @param $attributeNames
     * @return bool
     * @throws \yii\base\Exception
     */
    public function save($runValidation = true, $attributeNames = null): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $isInsert = $this->isNewRecord;

            if ($isInsert) {
                $this->video_id = Yii::$app->security->generateRandomString(8);
                $this->title = $this->video->name;
                $this->video_name = $this->video->name;
            }

            if ($this->thumbnail) {
                $this->has_thumbnail = 1;
            }

            $saved = parent::save($runValidation, $attributeNames);

            if (!$saved) {
                return false;
            }

            if ($isInsert) {
                $videoPath = Yii::getAlias('@frontend/web/storage/videos/' . $this->video_id . '.mp4');

                if (!is_dir(dirname($videoPath))) {
                    FileHelper::createDirectory(dirname($videoPath));
                }

                $this->video->saveAs($videoPath);
            }

            if ($this->thumbnail) {
                $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/' . $this->video_id . '.jpg');
                if (!is_dir(dirname($thumbnailPath))) {
                    FileHelper::createDirectory(dirname($thumbnailPath));
                }

                $this->thumbnail->saveAs($thumbnailPath);

                Image::getImagine()
                    ->open($thumbnailPath)
                    ->thumbnail(new Box(1280, 1280))
                    ->save();
            }

            $transaction->commit();
            return true;
        } catch (\yii\base\Exception $e) {
            $this->addError('video', $e->getMessage());
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * get video link
     * @return string
     */
    public function getVideoLink(): string
    {
        return Yii::$app->params['frontendUrl'] . '/storage/videos/' . $this->video_id . '.mp4';
    }

    /**
     * Get thumbnail link
     * @return string
     */
    public function getThumbnailLink(): string
    {
        return $this->has_thumbnail ? Yii::$app->params['frontendUrl'] . '/storage/thumbs/' . $this->video_id . '.jpg'
            : '';
    }

    /**
     * @return void
     */
    public function afterDelete()
    {
        parent::afterDelete();

        $videoPath = Yii::getAlias('@frontend/web/storage/videos/' . $this->video_id . '.mp4');
        unlink($videoPath);

        $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/' . $this->video_id . '.jpg');
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
    }

    /**
     * Is liked by
     * @param $userId
     * @return array|VideoLike|null
     */
    public function isLikedBy($userId)
    {
        return VideoLike::find()
            ->userIdVideoId($userId, $this->video_id)
            ->liked()
            ->one();
    }

    /**
     * Is disliked by
     * @param $userId
     * @return array|VideoLike|null
     */
    public function isDislikedBy($userId)
    {
        return VideoLike::find()
            ->userIdVideoId($userId, $this->video_id)
            ->disliked()
            ->one();
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function belongsTo(int $userId): bool
    {
        return $this->created_by === $userId;
    }
}
