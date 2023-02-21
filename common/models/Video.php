<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;

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
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @var \yii\web\UploadedFile
     */
    public $video;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%video}}';
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

            [['description'], 'string'],
            [['status', 'has_thumbnail', 'created_at', 'updated_at'], 'integer'],
            [['title', 'tags', 'video_name'], 'string', 'max' => 512],

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
        try {
            $isInsert = $this->isNewRecord;

            if ($isInsert) {
                $this->video_id = Yii::$app->security->generateRandomString(8);
                $this->title = $this->video->name;
                $this->video_name = $this->video->name;
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
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }

        return true;
    }
}
