<?php

namespace app\controllers;

use app\components\Controller;
use app\models\social\FacebookProfile;
use app\models\social\TwitterProfile;
use app\models\User;
use Yii;
use app\models\LoginForm;
use app\models\social\LoginForm as SocialLoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\authclient\ClientInterface;
use yii\authclient\Collection;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    /**
     * Default Index
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout functionality
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Contact Us page
     * Sends Email
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * About static page
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Register account
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Initiate Password Reset Request
     * Sends to registered Email reset-password link
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Access password-reset link received into Email
     * and set new password
     *
     * @param string $token Password reset token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException If input token is invalid
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Social login testing purposes.
     *
     * @return string
     */
    public function actionSocialLogin()
    {
        return $this->render('social-login');
    }

    /**
     * Social Login callback handler.
     *
     * @param ClientInterface $client Social login client
     * @throws BadRequestHttpException For invalid callback
     */
    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        if ($client->getId() == 'facebook') {
            $attributes['picture'] = $client->api('me/picture?redirect=0&height=200&type=normal&width=200', 'GET');
            $profile = new FacebookProfile($attributes);
        } elseif ($client->getId() == 'twitter') {
            $profile = new TwitterProfile($attributes);
        } else {
            throw new BadRequestHttpException();
        }

        $login = new SocialLoginForm(compact('profile'));

        if ($login->authenticate()) {
            if (!empty($_GET['event_id'])) {
                $joinEventUrl = Url::to(['event/join', 'id' => $_GET['event_id']]);
                Yii::$app->user->setReturnUrl($joinEventUrl);
            }
            return;
        }
        throw new BadRequestHttpException();
    }

    /**
     * This will be the page where user need to set email when signed up thru twitter.
     */
    public function actionSignupCompletion()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_SIGNUP_COMPLETION;

        if ($user->email) {
            return $this->redirect(['/profile']);
        }
        
        if (Yii::$app->request->isPost) {
            $user->load(Yii::$app->request->post());
            if ($user->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Profile updated'));
                $this->redirect(['/profile']);
            }
        }

        return $this->render('signup-completion', compact('user'));
    }
}
