<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "shared_event".
 * It represents user's
 *
 * @property integer $id
 * @property integer $event_id FK Event
 * @property integer $user_id FK User
 * @property integer $social Social Id See Social::TWITTER and Social::FACEBOOK
 * @property string $sent_at Timestamp when event was shared/sent from user's behalf
 *
 * @property User $user User relation
 * @property Event $event Event relation
 */
class SharedEvent extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shared_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id', 'social'], 'required'],
            [['event_id', 'user_id', 'social'], 'integer'],
            [['sent_at'], 'safe'],
            [['event_id', 'user_id', 'social'], 'unique', 'targetAttribute' => ['event_id', 'user_id', 'social'], 'message' => 'The combination of Event ID, User ID and Social has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'user_id' => 'User ID',
            'social' => 'Social',
            'sent_at' => 'Sent At',
        ];
    }

    /**
     * @inheritdoc Increase event awareness counter
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $social = $this->getUserSocial();

            $this->db->createCommand()->update(
                'event',
                ['awareness_created_counter' => new Expression('awareness_created_counter + ' . $social->followers)],
                'id = :event',
                [':event' => $this->event_id]
            )->execute();
        }
    }

    /**
     * @inheritdoc Decrease event awareness counter
     */
    public function afterDelete()
    {
        $social = $this->getUserSocial();

        $this->db->createCommand()->update(
            'event',
            ['awareness_created_counter' => new Expression('awareness_created_counter - ' . $social->followers)],
            'id = :event',
            [':event' => $this->event_id]
        )->execute();
    }

    /**
     * @return Social social profile related to the current user and social network
     */
    public function getUserSocial()
    {
        return Social::find()->where([
            'social' => $this->social,
            'user_id' => $this->user_id,
        ])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}
