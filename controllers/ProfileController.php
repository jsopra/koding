<?php

namespace app\controllers;

use app\components\Controller;
use app\models\forms\ProfileForm;
use Yii;
use yii\filters\AccessControl;

/**
 * Class ProfileController
 * @package app\controllers
 */
class ProfileController extends Controller
{

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
        $user = new ProfileForm(['user' => Yii::$app->user->identity]);
        
        if (Yii::$app->request->isPost) {
            $user->load(Yii::$app->request->post());
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated.');
            } else {
                Yii::$app->session->setFlash('error', 'Unable to update profile.');
            }
        }
        
        return $this->render('index', compact('user'));
    }
}
