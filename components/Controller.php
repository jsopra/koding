<?php

namespace app\components;

use Yii;
use yii\helpers\Url;

/**
 * Class Controller
 * @package app\components
 */
class Controller extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->email) {
            $requiredDetailsPage = Yii::$app->request->url;
            $url = Url::to(['/site/signup-completion']);
            if ($url != $requiredDetailsPage) {
                $this->redirect($url);
            }
        }
        return parent::beforeAction($action);
    }
}
