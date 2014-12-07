<?php

namespace app\models;

/**
 * Class UserRelationTrait
 *
 * Includes Relations for User model
 * @see User
 *
 * @package app\models
 * @mixin User
 */
trait UserRelationTrait
{
    /**
     * Get User's Country
     *
     * @return \yii\db\ActiveQuery Country
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * Get User's City
     *
     * @return \yii\db\ActiveQuery City
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
