<?php

namespace app\controllers;

use Yii;
use app\filters\UnpersistedHttpAuth;
use app\models\Event;
use app\models\EventSearch;
use app\models\chart\EventChart;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
                'class' => AccessControl::className(),
                'only' => ['join', 'unjoin'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['join', 'unjoin'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'unpersistedHttpAuth' => [
                'class' => UnpersistedHttpAuth::className(),
                'only' => ['create', 'update', 'delete'],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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
        $searchModel = new EventSearch;
        $dataProvider = $searchModel->search([]);

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
            'eventChart' => new EventChart(['event' => $model]),
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event;

        if ($model->load(Yii::$app->request->post())) {
            $this->prepareFile($model, 'image');
            $this->prepareFile($model, 'thumbnail');

            if ($model->save()) {
                $this->saveFile($model, 'image');
                $this->saveFile($model, 'thumbnail');

                return $this->redirectToView($model);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id record ID
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $this->prepareFile($model, 'image');
            $this->prepareFile($model, 'thumbnail');

            if ($model->save()) {
                $this->saveFile($model, 'image');
                $this->saveFile($model, 'thumbnail');

                return $this->redirectToView($model);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Saves a file resource to the filesystem
     * @param Event $model event object
     * @param string $resource resource name (image or thumbnail)
     */
    protected function saveFile($model, $resource)
    {
        $fileAttribute = $resource . '_file';
        $nameAttribute = $resource . '_name';

        $resource = $model->$fileAttribute;

        if ($resource) {
            $name = implode('.', [
                $model->tableName(),
                $model->id,
                $resource,
                md5_file($resource->tempName),
                $resource->getExtension()
            ]);

            if ($model->$nameAttribute) {
                Yii::$app->resourceManager->delete($model->$nameAttribute);
            }

            Yii::$app->resourceManager->save($resource, $name);

            $model->$nameAttribute = $name;
            $model->update(false, [$nameAttribute]);
        }
    }

    /**
     * Loads a file resource into the object
     * @param Event $model event object
     * @param string $resource resource name (image or thumbnail)
     */
    protected function prepareFile($model, $resource)
    {
        $fileAttribute = $resource . '_file';
        $model->$fileAttribute = UploadedFile::getInstance($model, $fileAttribute);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id record ID
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Joins current user to the event
     * @param integer $id event ID
     * @return mixed
     */
    public function actionJoin($id)
    {
        $model = $this->findModel($id);

        if (!$model->isPast()) {
            $model->join(Yii::$app->user->identity);
            Yii::$app->session->setFlash('success', 'Thank you for joining this event!');
        }

        return $this->redirectToView($model);
    }

    /**
     * Unjoins current user from the event
     * @param integer $id event ID
     * @return mixed
     */
    public function actionUnjoin($id)
    {
        $model = $this->findModel($id);

        if (!$model->isPast()) {
            $model->unjoin(Yii::$app->user->identity);
            Yii::$app->session->setFlash('success', 'You have successfully unjoined this event.');
        }

        return $this->redirectToView($model);
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

    /**
     * Redirects to view with pretty URL
     * @param Event $model record
     * @return mixed response
     */
    protected function redirectToView($model)
    {
        return $this->redirect(
            [
                'view',
                'id' => $model->id,
                'url' => Inflector::slug($model->name)
            ]
        );
    }
}
