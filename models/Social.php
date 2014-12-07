<?php

namespace app\models;

use app\models\social\Profile;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Social
 * @property int $user_id
 * @property string $social
 * @property string $social_id
 * @property string $meta
 * @property User $user
 * @property string $token
 * @package app\models
 */
class Social extends ActiveRecord
{
    
    const TWITTER = 1;
    const FACEBOOK = 2;

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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @param Profile $profile Social profile
     * @return Social
     */
    public static function findByProfile(Profile $profile)
    {
        return Social::find()
            ->where([
                'social' => $profile->social,
                'social_id' => $profile->id,
            ])
            ->one();
    }
}
