<?php

namespace app\console;

use app\models\User;
use yii\console\Controller;

/**
 * Class ShareController
 * @package app\console
 */
class ShareController extends Controller
{
    /**
     * Sample usage
     */
    public function actionSample()
    {
        /** @var User $user */
        $user = User::find()->one();
        $user->twitter->sharer->post([
            'message' => 'test',
        ]);
        $sharer = $user->facebook->sharer;
        $sharer->post([
            'message' => 'test',
            'link' => 'http://darku.nz'
        ]);
    }
}
