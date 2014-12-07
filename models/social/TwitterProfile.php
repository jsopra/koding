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
     * @param Profile $profile Social profile
     * @return User
     */
    public static function createUser(Profile $profile)
    {
        $user = new User([
            'registered_via' => $profile->social,
        ]);
        if (!$user->save(false)) {
            return null;
        }
        return $user;
    }
}