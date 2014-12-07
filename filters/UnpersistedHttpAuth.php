<?php
namespace app\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

/**
 * Controller filter which requires an HTTP authentication that does not
 * register an Yii::$app->user->identity object.
 */
class UnpersistedHttpAuth extends ActionFilter
{
    /**
     * @var string HTTP username
     */
    public $username;

    /**
     * @var string HTTP password
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($this->isActive($action)) {
            if (!$this->authenticate()) {
                Yii::$app->response->headers->set('WWW-Authenticate', 'Basic realm="authentication"');
                throw new UnauthorizedHttpException('Please enter your username and password.');
            }
        }

        return true;
    }

    /**
     * Authenticates user
     * @return boolean if user was successfully authenticated
     */
    protected function authenticate()
    {
        if (empty($_SERVER['PHP_AUTH_USER'])) {
            return false;
        }

        return (
            $_SERVER['PHP_AUTH_USER'] == getenv('SW_ADMIN_HTTP_USERNAME')
            && $_SERVER['PHP_AUTH_PW'] == getenv('SW_ADMIN_HTTP_PASSWORD')
        );
    }
}
