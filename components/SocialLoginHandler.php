<?php

namespace app\components;

use app\models\social\ConnectForm;
use app\models\social\FacebookProfile;
use app\models\social\LoginForm;
use app\models\social\Profile;
use app\models\social\TwitterProfile;
use yii\authclient\ClientInterface;
use yii\authclient\clients\Facebook;
use yii\authclient\clients\Twitter;
use yii\base\Object;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

/**
 * Class SocialLoginHandler
 * @package app\components
 */
class SocialLoginHandler extends Object
{

    /**
     *  Social connect handler
     *
     * @param ClientInterface $client Auth Client
     * @throws BadRequestHttpException Unable to process
     */
    public function connectHandler($client)
    {
        $profile = $this->getProfile($client);
        $connect = new ConnectForm([
            'user' => \Yii::$app->user->identity,
            'profile' => $profile,
        ]);
        
        if (!$connect->connect()) {
            throw new BadRequestHttpException();
        }
    }
    
    /**
     * @param ClientInterface $client Auth Client
     * @throws BadRequestHttpException Unable to process
     */
    public function loginHandler($client)
    {
        $profile = $this->getProfile($client);
        $login = new LoginForm(compact('profile'));
        if ($login->authenticate()) {
            if (!empty($_GET['event_id'])) {
                $joinEventUrl = Url::to(['event/join', 'id' => $_GET['event_id']]);
                \Yii::$app->user->setReturnUrl($joinEventUrl);
            }
            return;
        }
        throw new BadRequestHttpException();
    }

    /**
     * @param ClientInterface $client Auth Client
     * @return Profile
     * @throws BadRequestHttpException Unable to process
     */
    protected function getProfile($client)
    {
        if ($client->getId() == 'facebook') {
            return $this->facebook($client);
        } elseif ($client->getId() == 'twitter') {
            return $this->twitter($client);
        } else {
            throw new BadRequestHttpException();
        }
    }

    /**
     * @param Facebook $client Auth Client
     * @return FacebookProfile
     */
    protected function facebook($client)
    {
        $attributes = $client->getUserAttributes();
        $attributes['picture'] = $client->api('me/picture?redirect=0&height=200&type=normal&width=200', 'GET');
        $params = [
            'client_id' => $client->clientId,
            'client_secret' => $client->clientSecret,
            'grant_type' => 'client_credentials'
        ];
        $url = $client->tokenUrl . '?' . http_build_query($params);
        $token = $this->getFacebookAppToken($url);
        return new FacebookProfile($attributes, $token);
    }

    /**
     * Workaround for getting facebook app token.
     * Yii-authclient is having an issue handling plain/text response.
     *
     * @param string $url API Url
     * @return string
     * @throws BadRequestHttpException Unable to process
     */
    protected function getFacebookAppToken($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Social Warming OAuth 2.0 Client');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        
        if (strstr($response, 'access_token=') == false) {
            throw new BadRequestHttpException();
        }
        
        return str_replace('access_token=', '', $response);
    }
    
    /**
     * @param Twitter $client Auth client
     * @return TwitterProfile
     */
    protected function twitter($client)
    {
        $attributes = $client->getUserAttributes();
        /** @var Twitter $client */
        return new TwitterProfile($attributes, $client->accessToken->params);
    }
}
