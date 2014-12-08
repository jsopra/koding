<?php

namespace app\models\social;

use app\models\Social;
use app\models\User;
use yii\helpers\Json;

/**
 * Class TwitterProfile
 */
class TwitterProfile extends Profile
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['id', 'required'],
        ];
    }

    /**
     * @return int
     */
    public function getSocial()
    {
        return Social::TWITTER;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getRawAttribute('id');
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getMeta()
    {
        $rawAttributes = $this->rawAttributes;
        unset($rawAttributes['entities']);
        unset($rawAttributes['status']);
        return Json::encode($this->rawAttributes);
    }

    /**
     * @return mixed|void
     */
    public function getToken()
    {
        return Json::encode($this->accessToken);
    }
    
    /**
     * @inheritdoc
     */
    public function getFollowers()
    {
        return $this->getRawAttribute('followers_count');
    }

    /**
     * No Expiration
     *
     * @return mixed|null
     */
    public function getTokenExpiration()
    {
        return null;
    }
    
    /**
     * @param Profile $profile Social profile
     * @return User
     */
    public static function createUser(Profile $profile)
    {
        $user = new User([
            'registered_via' => $profile->social,
            'photo' => str_replace('_normal', '', $profile->getRawAttribute('profile_image_url')),
        ]);
        if (!$user->save(false)) {
            return null;
        }
        return $user;
    }
}
