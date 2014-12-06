<?php

namespace app\models\social;

use app\models\Social;
use yii\base\Object;
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
}
