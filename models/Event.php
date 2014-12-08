<?php

namespace app\models;

use Yii;
use app\validators\HashtagValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $name
 * @property string $hashtag
 * @property string $description
 * @property string $occurred_on
 * @property string $short_url
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $awareness_created_counter
 * @property integer $joined_users_counter
 * @property integer $sharing_counter
 * @property string $image_name
 * @property string $thumbnail_name
 * @property string $sentiment
 * @property float $sentiment_confidence
 *
 * Relations:
 * @property User[] $users Users following this event
 * @property EventUser[] $eventUsers
 * @property SharedEvent[] $shared User shares for this event
 *
 */
class Event extends ActiveRecord
{
    /**
     * Temporary store for uploaded image file
     * @var \yii\web\UploadedFile
     */
    public $image_file;

    /**
     * Temporary store for uploaded thumbnail file
     * @var \yii\web\UploadedFile
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
            [['joined_users_counter', 'awareness_created_counter', 'sharing_counter'], 'integer'],
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
            'sharing_counter' => 'Sharing Counter',
        ];
    }

    /**
     * @inheritdoc
     * @return EventQuery scopes object
     */
    public static function find()
    {
        return Yii::createObject(EventQuery::className(), [get_called_class()]);
    }

    /**
     * @inheritdoc
     * Joins all users into this event
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            foreach (User::find()->select('id')->all() as $user) {
                $this->join($user);
            }
        }
    }

    /**
     * @return array sentiment data for the event description
     */
    protected function getSentimentData()
    {
        $url = 'https://community-sentiment.p.mashape.com/text/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Mashape-Authorization: ' . getenv('SW_MASHAPE_KEY')
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'txt=' . urlencode($this->description));
        
        $response = curl_exec($ch);

        curl_close($ch);

        return $response ? Json::decode($response) : [];
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
     * User shares for this event
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShared()
    {
        return $this->hasMany(SharedEvent::className(), ['event_id' => 'id']);
    }

    /**
     * @return boolean if this event is already passed
     */
    public function isPast()
    {
        $currentDate = (int) date('Ymd');
        $eventDate = (int) preg_replace('/[^0-9]/', '', $this->occurred_on);

        return $eventDate <= $currentDate;
    }

    /**
     * Joins user to the event
     * @param User|\yii\web\IdentityInterface|\yii\db\ActiveRecord $user user which will join
     * @returns boolean either if the user joined or not
     */
    public function join(User $user)
    {
        $eventUser = new EventUser;
        $eventUser->event_id = $this->id;
        $eventUser->user_id = $user->id;

        return $eventUser->save();
    }

    /**
     * Unjoins user from the event
     * @param User|\yii\web\IdentityInterface $user user which will unjoin
     * @returns boolean either if the user unjoined or not
     */
    public function unjoin(User $user)
    {
        $eventUser = EventUser::find()->where([
            'event_id' => $this->id,
            'user_id' => $user->id,
        ])->one();

        return ($eventUser && $eventUser->delete() > 0);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!Yii::$app->request->isConsoleRequest && !$this->short_url) {
                $url = Url::to(['event/view', 'id' => $this->id], true);
                $this->short_url = Yii::$app->urlShortener->shorten($url);
            }

            // Get the sentiment
            $sentimentData = $this->getSentimentData();

            if ($sentimentData) {
                $this->sentiment = $sentimentData['result']['sentiment'];
                $this->sentiment_confidence = ($sentimentData['result']['confidence'] / 100);
            }

            return true;
        }
        return false;
    }
}
