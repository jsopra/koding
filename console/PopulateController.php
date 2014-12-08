<?php

namespace app\console;

use app\models\Event;
use app\models\EventUser;
use app\models\SharedEvent;
use app\models\Social;
use app\models\User;
use yii\console\Controller;
use Faker\Factory as Faker;
use yii\helpers\Console;

/**
 * This command populates the database with random data
 */
class PopulateController extends Controller
{
    /**
     * @var \Faker\Generator $faker Faker Generator instance;
     */
    protected $faker;

    /**
     * @var int $count Number of records added
     */
    protected $count = 0;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
             $this->faker = Faker::create();
             return true;  // or false if needed
        } else {
            return false;
        }
    }

    /**
     * Helper Iterator
     *
     * @param int $count number of iterations
     * @param callable $callback Callback
     */
    private function call($count, $callback)
    {
        for ($i = 0; $i < $count; $i++) {
            $callback();
        }
    }

    /**
     * This command populates database with fake data
     */
    public function actionIndex()
    {
        $this->actionUsers();
        $this->actionFollowers();
        $this->actionSocials();
        $this->actionShareEvents();
    }

    /**
     * Create random Users. Default 10
     *
     * @param int $number Number of users. Default 10
     */
    public function actionUsers($number = 10)
    {
        $this->count = 0;
        $this->call($number, function() {
            $user = new User([
                'username' => $this->faker->userName,
                'email' => $this->faker->email,
                'country' => $this->faker->randomElement([
                    'US',
                    $this->faker->countryCode,
                    $this->faker->countryCode,
                    $this->faker->countryCode,
                    $this->faker->countryCode
                ]),
                'city' => $this->faker->city,
                'created_at' => $this->faker->dateTimeBetween('-90days')->getTimestamp(),
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
            ]);
            if (!empty($user->city) && !empty($user->country)) {
                $user->address = "{$user->city->name}, {$user->country->name}";
            }
            if ($user->save()) {
                $this->count++;
            }
        });

        $this->stdout($this->count, Console::FG_GREEN);
        $this->stdout(" users added");
        $this->stdout("\n");
    }

    /**
     * Follows random Events by random Users. Default 50
     *
     * @param int $number Number of follows to create. Default 50
     */
    public function actionFollowers($number = 50)
    {
        $this->count = 0;
        $this->call($number, function() {
            $user = self::getRandomUser();
            $event = self::getRandomEvent();

            $eventUser = new EventUser();
            $eventUser->event_id = $event->id;
            $eventUser->user_id = $user->id;
            // don't set Joined date before User or Event creation
            $eventUser->joined_at = $this->faker->dateTimeBetween(
                \DateTime::createFromFormat('U', max([$event->created_at,$user->created_at]))
            )->getTimestamp();

            if ($eventUser->save()) {
                $this->count++;
            }
        });

        $this->stdout($this->count, Console::FG_GREEN);
        $this->stdout(" followers added");
        $this->stdout("\n");
    }

    /**
     * Creates random social network associations with users.
     */
    public function actionSocials()
    {
        $this->count = 0;
        foreach (User::find()->all() as $user) {
            // If there is no social profile associated
            if (Social::find()->where(['user_id' => $user->id])->count() == 0) {
                $profilesToBeGenerated = rand(1, 2);
                for ($i = 1; $i <= $profilesToBeGenerated; $i++) {
                    $social = new Social;
                    $social->user_id = $user->id;
                    $social->social = $i;
                    $social->followers = rand(1, 500);
                    $social->social_id = ($user->id * -1);
                    $social->meta = '{}';
                    $social->token = uniqid();
                    if ($social->save()) {
                        $this->count++;
                    }
                }
            }
        }

        $this->stdout($this->count, Console::FG_GREEN);
        $this->stdout(" users connected to social networks");
        $this->stdout("\n");
    }

    /**
     * Randomly share events
     */
    public function actionShareEvents($number = 50)
    {
        $this->count = 0;
        $this->call($number, function() {
            $user = $this->getRandomUser();
            $event = $this->getRandomEvent();

            // If there is no social profile associated
            $socials = Social::find()->where(['user_id' => $user->id])->all();
            if ($socials) {
                foreach ($socials as $social) {
                    // Maybe the combination already exists and it won't save
                    $share = new SharedEvent;
                    $share->event_id = $event->id;
                    $share->user_id = $user->id;
                    $share->social = $social->social;
                    if ($share->save()) {
                        $this->count++;
                    }
                }
            }
        });

        $this->stdout($this->count, Console::FG_GREEN);
        $this->stdout(" event sharings were made");
        $this->stdout("\n");
    }

    /**
     * Get Random User
     *
     * @return array|null|\yii\db\ActiveRecord|\app\models\User
     */
    private static function getRandomUser()
    {
        return User::find()->orderBy('RAND()')->one();
    }

    /**
     * Get Random Event
     *
     * @return array|null|\yii\db\ActiveRecord|\app\models\Event
     */
    private static function getRandomEvent()
    {
        return Event::find()->orderBy('RAND()')->one();
    }
}
