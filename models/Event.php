<?php

namespace app\models;

use Yii;
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
 *
 * Relations:
 * @property User[] $users
 * @property EventUser[] $eventUsers
 */
class Event extends \yii\db\ActiveRecord
{
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
            [['name', 'hashtag', 'description', 'occurred_on', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['occurred_on'], 'safe'],
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
