<?php

namespace app\models\social;

use app\models\Social;
use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Class ConnectForm
 *
 * Connect social account to an existing user.
 *
 * @package app\models\social
 */
class ConnectForm extends Model
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var Profile
     */
    public $profile;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user', 'profile'], 'required'],
        ];
    }
    
    /**
     * Connect social account
     */
    public function connect()
    {
        if (!$this->validate()) {
            return false;
        }
        if (!$this->profile->validate()) {
            $this->addError('profile', Yii::t('app', 'Profile details contains invalid information.'));
            return false;
        }
        $social = Social::findByProfile($this->profile);
        
        if (!$social) {
            $social = new Social();
        }

        $social->user_id = $this->user->id;
        $social->meta = $this->profile->meta;
        $social->social = $this->profile->social;
        $social->social_id = $this->profile->id;
        $social->token = $this->profile->token;
        $social->followers = $this->profile->followers;
        
        if (!$social->save()) {
            $this->addError('profile', Yii::t('app', 'Something went wrong while creating social profile.'));
            return false;
        }
        return true;
    }
}
