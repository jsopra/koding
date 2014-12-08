<?php

namespace app\controllers;

use app\components\Controller;
use app\components\SocialLoginHandler;
use app\models\forms\ProfileForm;
use Yii;
use yii\authclient\AuthAction;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Class ProfileController
 * @package app\controllers
 */
class ProfileController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'connect' => [
                'class' => AuthAction::className(),
                'successUrl' => Url::to(['/profile']),
                'successCallback' => [new SocialLoginHandler(), 'connectHandler'],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'roles' => ['@'],
                        'allow' => true,
                    ]
                ]
            ]
        ];
    }

    /**
     * Profile Page
     */
    public function actionIndex()
    {
        $model = new ProfileForm(['user' => Yii::$app->user->identity]);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated.');
            } else {
                Yii::$app->session->setFlash('error', 'Unable to update profile.');
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}
