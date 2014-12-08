<?php

namespace app\models;

use app\models\sharer\Facebook;
use app\models\sharer\SharerInterface;
use app\models\sharer\Twitter;
use app\models\social\Profile;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Social
 * @property int $user_id
 * @property string $social
 * @property string $social_id
 * @property string $meta
 * @property User $user
 * @property string $token
 * @property integer $followers
 *
 * Magic:
 * @property SharerInterface $sharer
 *
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

    /**
     * @return SharerInterface
     */
    public function getSharer()
    {
        if (!$this->token) {
            return null;
        }
        
        if ($this->social == self::TWITTER) {
            $details = Json::decode($this->token);
            $credentials = [
                'token' => $details['oauth_token'],
                'token_secret' => $details['oauth_token_secret'],
                'consumer_key' => getenv('SW_TWITTER_CONSUMER_KEY'),
                'consumer_secret' => getenv('SW_TWITTER_CONSUMER_SECRET'),
            ];
            return new Twitter($credentials);
        } elseif ($this->social == self::FACEBOOK) {
            return new Facebook($this->token, $this->social_id);
        }
        return null;
    }
}
