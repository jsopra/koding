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
 * @property string $token
 * @property int $tokenExpiration
 * @package app\models\social
 */
abstract class Profile extends Model
{

    /**
     * Raw attributes got from authentication.
     *
     * @var array
     */
    protected $rawAttributes;

    /**
     * @var mixed
     */
    protected $accessToken;
    
    /**
     * @param array $rawAttributes Social attributes
     * @param mixed $accessToken Retrieved access token
     */
    public function __construct($rawAttributes, $accessToken)
    {
        $this->accessToken = $accessToken;
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
     * @param string $attribute Attribute name
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
     * @return mixed
     */
    abstract public function getToken();
    
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
