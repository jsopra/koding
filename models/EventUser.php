<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "event_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $event_id
 * @property integer $joined_at
 *
 * Relations:
 * @property User $user
 * @property Event $event
 */
class EventUser extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'joined_at',
                'updatedAtAttribute' => false,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'event_id'], 'required'],
            [['user_id', 'event_id'], 'integer'],
            [
                ['user_id', 'event_id'],
                'unique',
                'targetAttribute' => ['user_id', 'event_id'],
                'message' => 'The user already joined the event.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'event_id' => 'Event ID',
            'joined_at' => 'Joined At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $this->db->createCommand()->update(
                'event',
                ['joined_users_counter' => new Expression('joined_users_counter + 1')],
                'id = :event',
                [':event' => $this->event_id]
            )->execute();
        }
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $this->db->createCommand()->update(
            'event',
            ['joined_users_counter' => new Expression('joined_users_counter - 1')],
            'id = :event',
            [':event' => $this->event_id]
        )->execute();
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
