<?php

namespace app\console;

use app\models\Event;
use app\models\SharedEvent;
use app\models\Social;
use app\models\User;
use yii\console\Controller;

/**
 * Class ShareController
 * @package app\console
 */
class ShareController extends Controller
{

    /**
     * Command
     */
    public function actionIndex()
    {
        $events = Event::find()
            ->where(['occurred_on' => date('Y-m-d')])
            ->all();
        
        foreach ($events as $event) {
            $this->spreadTheEvent($event);
        }
    }
    
    /**
     * @param Event $event The Event
     */
    public function spreadTheEvent($event)
    {
        foreach ($event->users as $user) {
            $this->tweet($event, $user);
            $this->postToFacebook($event, $user);
        }
    }

    /**
     * @param Event $event The Event
     * @param User $user Joined User
     */
    public function tweet($event, $user)
    {
        if (!$user->twitter) {
            return;
        }
        
        $shared = SharedEvent::find()
            ->where([
                'user_id' => $user->id,
                'social' => Social::TWITTER,
                'event_id' => $event->id,
            ])
            ->count();
        if ($shared) {
            return;
        }
        
        $tweet = $event->name . ' ' . ($event->short_url ? $event->short_url . ' ' : '') . $event->hashtag;
        $sharer = $user->twitter->sharer;
        $result = $sharer->post([
            'message' => $tweet,
        ]);

        if ($result) {
            (new SharedEvent([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'social' => Social::TWITTER,
                'sent_at' => date('Y-m-d H:i:s'),
            ]))->save();
        } else {
            \Yii::error('Post to facebook failed. ' . $sharer->errorMessage);
        }
    }

    /**
     * @param Event $event The Event
     * @param User $user Joined User
     */
    public function postToFacebook($event, $user)
    {
        if (!$user->facebook) {
            return;
        }

        $shared = SharedEvent::find()
            ->where([
                'user_id' => $user->id,
                'social' => Social::FACEBOOK,
                'event_id' => $event->id,
            ])
            ->count();
        
        if ($shared) {
            return;
        }

        $message = $event->name . ' ' . $event->hashtag;
        $sharer = $user->facebook->sharer;
        $result = $sharer->post([
            'message' => $message,
            'link' => $event->short_url,
        ]);
        
        if ($result) {
            (new SharedEvent([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'social' => Social::FACEBOOK,
                'sent_at' => date('Y-m-d H:i:s'),
            ]))->save();
        } else {
            \Yii::error('Post to facebook failed. ' . $sharer->errorMessage);
        }
    }
}
