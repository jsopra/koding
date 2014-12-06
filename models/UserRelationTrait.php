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
     * Get User's region
     *
     * @return \yii\db\ActiveQuery Region
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
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

    /**
     * Get User's location in simple readable form
     *
     * @return string Representation of `$country, $region, $city`
     */
    public function getLocation()
    {
        $fields = ['country', 'region', 'city'];
        $location = [];

        foreach ($fields as $field) {
            if (!empty($this->$field) && !empty($this->$field->name)) {
                $location[] = ucfirst($this->$field->name);
            }
        }

        return implode(', ', $location);
    }
}
