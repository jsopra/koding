<?php

namespace app\models;

use Yii;
use app\validators\HashtagValidator;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $name
 * @property string $hashtag
 * @property string $description
 * @property string $occurred_on
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $awareness_created_counter
 * @property integer $joined_users_counter
 * @property string $image_name
 * @property string $thumbnail_name
 *
 * Relations:
 * @property User[] $users
 * @property EventUser[] $eventUsers
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * Temporary store for uploaded image file
     * @var yii\web\UploadedFile
     */
    public $image_file;

    /**
     * Temporary store for uploaded thumbnail file
     * @var yii\web\UploadedFile
     */
    public $thumbnail_file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'hashtag', 'description', 'occurred_on'], 'required'],
            [['description'], 'string'],
            [['occurred_on'], 'safe'],
            ['hashtag', HashtagValidator::className()],
            ['image_file', 'image', /*'maxWidth' => 630, 'minWidth' => 630, 'maxHeight' => 354, 'minHeight' => 354,*/ 'skipOnEmpty' => true],
            ['thumbnail_file', 'image', /*'maxWidth' => 630, 'minWidth' => 630, 'maxHeight' => 354, 'minHeight' => 354,*/ 'skipOnEmpty' => true],
            [['joined_users_counter', 'awareness_created_counter'], 'integer'],
            [['name', 'hashtag'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'hashtag' => 'Hashtag',
            'description' => 'Description',
            'occurred_on' => 'Occurred On',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'awareness_created_counter' => 'Awareness Created Counter',
            'joined_users_counter' => 'Joined Users Counter',
            'image_name' => 'Image',
            'thumbnail_name' => 'Thumbnail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('event_user', ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventUsers()
    {
        return $this->hasMany(EventUser::className(), ['event_id' => 'id']);
    }

    /**
     * Joins user to the event
     * @param User $user user which will join
     * @returns boolean either if the user joined or not
     */
    public function join(User $user)
    {
        $eventUser = new EventUser;
        $eventUser->event_id = $this->id;
        $eventUser->user_id = $user->id;

        if ($eventUser->save()) {
            $this->updateCounters(['joined_users_counter' => 1]);
            return true;
        }
        return false;
    }

    /**
     * Unjoins user from the event
     * @param User $user user which will unjoin
     * @returns boolean either if the user unjoined or not
     */
    public function unjoin(User $user)
    {
        $eventUser = EventUser::find()->where([
            'event_id' => $this->id,
            'user_id' => $user->id,
        ])->one();

        if ($eventUser && $eventUser->delete() > 0) {
            $this->updateCounters(['joined_users_counter' => -1]);
            return true;
        }
        return false;
    }
}
