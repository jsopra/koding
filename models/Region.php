<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "region".
 *
 * @property integer $id PK
 * @property string $name Region name
 *
 * @property User[] $users Users associated with this Region
 */
class Region extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'filter', 'filter' => 'ucfirst'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['region_id' => 'id']);
    }

    /**
     * Find Region, if doesn't exist - create it
     *
     * @param string $name Region name
     * @return self|null
     */
    public static function findOrCreate($name)
    {
        if ($model = static::findOne(['name' => trim($name)])) {
            return $model;
        } else {
            $model = new static();
            $model->name = $name;
            if ($model->save()) {
                return $model;
            }
        }

        return null;
    }
}
