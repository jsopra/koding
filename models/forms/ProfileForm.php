<?php

namespace app\models\forms;

use app\models\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ProfileForm
 * @package app\models\forms
 */
class ProfileForm extends Model
{
    /**
     * @var User
     */
    public $user;
    
    /**
     * @var array
     */
    protected $attributes = ['first_name', 'last_name', 'email', 'address', 'city', 'country', 'photo'];
    
    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if (in_array($name, $this->attributes)) {
            return $this->user->$name;
        }
        return parent::__get($name);
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->attributes)) {
            $this->user->$name = $value;
            return;
        }
        parent::__set($name, $value);
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return ArrayHelper::merge($this->attributes, []);
    }

    /**
     * @inheritdoc
     */
    public function safeAttributes()
    {
        return $this->attributes();
    }
    
    /**
     * @inheritdoc
     */
    public function save()
    {
        $user = $this->user;
        
        $user->scenario = User::SCENARIO_UPDATE;
        if (!$user->save()) {
            $this->copyErrors();
            return false;
        }
        return true;
    }

    /**
     * copy user error models
     */
    protected function copyErrors()
    {
        foreach ($this->attributes as $attribute) {
            if ($error = $this->user->getFirstError($attribute)) {
                $this->addError($attribute, $error);
            }
        }
    }
}
