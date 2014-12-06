<?php

namespace app\models\social;

use app\models\User;
use yii\base\Model;

/**
 * Class Profile
 * @property int $social
 * @property int $id
 * @property int $email
 * @property string $meta
 * @package app\models\social
 */
abstract class Profile extends Model
{

    /**
     * @var array
     */
    protected $rawAttributes;

    /**
     * @param array $rawAttributes Social attributes
     */
    public function __construct($rawAttributes)
    {
        $this->rawAttributes = $rawAttributes;
    }
    
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'id'], 'required'],
            [['email'], 'email'],
        ];
    }

    /**
     * @param string $attribute
     * @return null|string
     */
    protected function getRawAttribute($attribute)
    {
        return isset($this->rawAttributes[$attribute])
            ? $this->rawAttributes[$attribute]
            : null;
    }

    /**
     * @return mixed
     */
    abstract public function getSocial();

    /**
     * @return mixed
     */
    abstract public function getEmail();

    /**
     * @return mixed
     */
    abstract public function getId();

    /**
     * @return mixed
     */
    abstract public function getMeta();

    /**
     * Let social profile handle creating the user.
     *
     * @param Profile $profile Social profile
     * @return User
     */
    public static function createUser(Profile $profile)
    {
        $user = new User([
            'username' => $profile->email,
            'email' => $profile->email,
            'registered_via' => $profile->social,
        ]);
        if (!$user->save(false)) {
            return null;
        }
        return $user;
    }
}