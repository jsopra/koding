<?php

namespace app\models\social;

use app\models\Social;
use app\models\User;
use yii\helpers\Json;

/**
 * Class FacebookProfile
 * @package app\models\social
 */
class FacebookProfile extends Profile
{

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return $this->getRawAttribute('email');
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
    public function getSocial()
    {
        return Social::FACEBOOK;
    }
    
    /**
     * @inheritdoc
     */
    public function getMeta()
    {
        return Json::encode($this->rawAttributes);
    }

    /**
     * @return mixed|string
     */
    public function getToken()
    {
        return $this->accessToken;
    }

    /**
     * @return int|mixed
     */
    public function getTokenExpiration()
    {
        return time() + $this->accessToken['expires'];
    }
    
    /**
     * @inheritdoc
     */
    public static function createUser(Profile $profile)
    {
        $picture = $profile->getRawAttribute('picture');
        $user = new User([
            'username' => $profile->email,
            'email' => $profile->email,
            'registered_via' => $profile->social,
            'first_name' => $profile->getRawAttribute('first_name'),
            'last_name' => $profile->getRawAttribute('last_name'),
            'photo' => $picture ? $picture['data']['url'] : null,
        ]);
        if (!$user->save(false)) {
            return null;
        }
        return $user;
    }
}
