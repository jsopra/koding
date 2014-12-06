<?php

namespace app\models\social;

use app\models\Social;
use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Class LoginForm
 *
 * Authenticate user thru social login.
 *
 * @package app\models\social
 */
class LoginForm extends Model
{

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
            ['profile', 'required'],
        ];
    }
    
    /**
     * Authenticate using social profile
     */
    public function authenticate()
    {
        if (!$this->validate()) {
            return false;
        }
        if (!$this->profile->validate()) {
            $this->addError('profile', Yii::t('app', 'Profile contains invalid information.'));
            return false;
        }
        if ($social = Social::findByProfile($this->profile)) {
            Yii::$app->user->login($social->user);
            return true;
        }
        $user = $this->profile->email
            ? User::find()->where(['email' => $this->profile->email])->one()
            : null;
        
        if (!$user) {
            $profile = $this->profile;
            if (!($user = $profile::createUser($profile))) {
                $this->addError('profile', Yii::t('app', 'Something went wrong. Unable to create user.'));
                return false;
            }
        }
        $connectForm = new ConnectForm([
            'user' => $user,
            'profile' => $this->profile,
        ]);
        if (!$connectForm->connect()) {
            $this->addError('profile', Yii::t('app', 'Something went wrong while connecting to social profile.'));
            return false;
        }
        Yii::$app->user->login($user);
        return true;
    }
}
