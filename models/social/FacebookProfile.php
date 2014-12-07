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
     * @inheritdoc
     */
    public static function createUser(Profile $profile)
    {
        $user = new User([
            'username' => $profile->email,
            'email' => $profile->email,
            'registered_via' => $profile->social,
            'first_name' => $profile->getRawAttribute('first_name'),
            'last_name' => $profile->getRawAttribute('last_name'),
        ]);
        if (!$user->save(false)) {
            return null;
        }
        return $user;
    }
}
