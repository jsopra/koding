<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use app\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => '\yii\filters\AccessControl',
                'only' => ['join', 'unjoin'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['join', 'unjoin'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id record ID
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $joinings = $model->getEventUsers();

        return $this->render('view', [
            'model' => $model,
            'recentJoinings' => $joinings->with('user')->orderBy('id DESC')->limit(5)->all(),
        ]);
    }

    /**
     * Joins current user to the event
     * @param integer $id event ID
     * @return mixed
     */
    public function actionJoin($id)
    {
        $this->findModel($id)->join(Yii::$app->user->identity);

        Yii::$app->session->setFlash('success', 'Thank you for joining this event!');

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Unjoins current user from the event
     * @param integer $id event ID
     * @return mixed
     */
    public function actionUnjoin($id)
    {
        $this->findModel($id)->unjoin(Yii::$app->user->identity);

        Yii::$app->session->setFlash('success', 'You have successfully unjoined this event.');

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id record ID
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
