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
        if ($social) {
            $social->user_id = $this->user->id;
            if (!$social->save()) {
                $this->addError('profile', Yii::t('app', 'Something went wrong while creating social profile.'));
                return false;
            }
            return true;
        }
        $social = new Social([
            'user_id' => $this->user->id,
            'social' => $this->profile->social,
            'social_id' => $this->profile->id,
            'meta' => $this->profile->meta,
        ]);
        if (!$social->save()) {
            $this->addError('profile', Yii::t('app', 'Something went wrong while creating social profile.'));
            return false;
        }
        return true;
    }
}
