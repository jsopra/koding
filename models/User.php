<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * DB Fields:
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $via
 * @property integer $country_id Relation with `country`
 * @property integer $region_id Relation with `region`
 * @property integer $city_id Relation with `city`
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * Relations:
 * @property Country|null $country User's country
 * @property Region|null $region User's region
 * @property City|null $city User's city
 *
 * Magic Properties:
 * @property $location User's location, representation of $country, $region, $city
 */
class User extends ActiveRecord implements IdentityInterface
{
    use UserRelationTrait;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER]],

            [['role', 'status', 'registered_via', 'country_id', 'region_id', 'city_id', 'created_at', 'updated_at'], 'integer'],

            // FK check: 'country_id' must exist in 'country.id'
            ['country_id', 'exist', 'targetClass' => Country::className(), 'targetAttribute' => 'id'],
            // FK check: 'region_id' must exist in 'region.id'
            ['region_id', 'exist', 'targetClass' => Region::className(), 'targetAttribute' => 'id'],
            // FK check: 'city_id' must exist in 'city.id'
            ['city_id', 'exist', 'targetClass' => City::className(), 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username Input username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password Plain password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Add Country & bind country_id to User
     * TODO: Finish
     *
     * @param string $name Country Name
     * @return self
     */
    public function setCountry($name)
    {
        return $this;
    }

    /**
     * Add Region & bind region_id to User
     *
     * @param string $name Region Name
     * @return self
     */
    public function setRegion($name)
    {
        if ($region = Region::findOrCreate($name)) {
            $this->region_id = $region->primaryKey;
        }
        return $this;
    }

    /**
     * Add City & bind city_id to User
     *
     * @param string $name City Name
     * @return self
     */
    public function setCity($name)
    {
        if ($city = City::findOrCreate($name)) {
            $this->city_id = $city->primaryKey;
        }
        return $this;
    }
}
