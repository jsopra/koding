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
            [['created_at', 'updated_at'], 'integer'],
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
        ];
    }
}
