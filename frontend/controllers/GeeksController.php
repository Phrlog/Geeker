<?php
namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use common\models\Geeks;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\GeekForm;
use common\models\User;
use common\models\Likes;
use yii\web\Response;
use common\models\Subscription;

/**
 * Geeks controller
 */
class GeeksController extends Controller
{


    public $layout = 'base';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'geeks', 'create', 'view', 'feed', 'like', 'answer'],
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'geeks', 'view', 'feed', 'like', 'answer'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'geeks', 'view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id == 'like' || $action->id == 'answer') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Redirect to actionAll
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect('geeks/all');
    }

    /**
     * Display all geeks, get user likes
     *
     * @return string
     */
    public function actionAll()
    {
        $geeks = Geeks::find()
            ->select(['geeks.*', 'user.username', 'COUNT(likes.geek_id) as count'])
            ->join('INNER JOIN', User::tableName(), 'user.id = geeks.user_id')
            ->join('LEFT JOIN', Likes::tableName(), 'likes.geek_id = geeks.id')
            ->groupBy(['geeks.id'])
            ->orderBy(['geeks.created_at' => SORT_DESC])
            ->all();

        $likes = Likes::getUserLikes(Yii::$app->user->id);

        return $this->render('all', [
            'geeks' => $geeks,
            'likes' => $likes
        ]);
    }

    /**
     * View geek and its answers by id
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $geek = Geeks::find()
            ->select(['geeks.*', 'COUNT(likes.geek_id) as count'])
            ->join('LEFT JOIN', Likes::tableName(), 'likes.geek_id = geeks.id')
            ->where(['id' => $id])
            ->groupBy(['geeks.id'])
            ->one();

        if ($geek === null) {
            throw new NotFoundHttpException;
        }

        $answers = Geeks::find()
            ->where(['parent_id' => $id])
            ->all();

        return $this->render('view', [
            'geek' => $geek,
            'answers' => $answers
        ]);
    }

    /**
     * Create new geek
     *
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new GeekForm();

        // Find your subscriptions
        $param = ['select' => 'subscribe_id', 'where' => 'user_id'];
        $all_id = User::getUsersId(Yii::$app->user->id, $param);

        // Find geeks of your subscriptions
        $geeks = Geeks::find()->select(['id as value', 'text as label'])->where(['user_id' => $all_id])->asArray()->all();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $result = "Твит успешно опубликован";
                $alert_type = 'success';
            } else {
                $result = "Неудача! Попробуйте снова";
                $alert_type = 'error';
            }

            Yii::$app->session->setFlash($alert_type, $result);

            return $this->refresh();
        }

        return $this->render('create', [
            'model' => $model,
            'geeks' => $geeks
        ]);
    }

    /**
     * Display your and your subscriptions geeks
     *
     * @return string
     */
    public function actionFeed()
    {
        // Find geeks of users on which we subscribed
        $geeks = Geeks::find()->select(['geeks.*', 'user.username', 'COUNT(likes.geek_id) as count'])
            ->join('INNER JOIN', User::tableName(), 'user.id = geeks.user_id')
            ->join('INNER JOIN', Subscription::tableName(), 'subscription.subscribe_id = user.id')
            ->join('LEFT JOIN', Likes::tableName(), 'likes.geek_id = geeks.id')
            ->where(['subscription.user_id' => Yii::$app->user->id])
            ->orWhere(['geeks.user_id' => Yii::$app->user->id])
            ->groupBy(['geeks.id'])
            ->orderBy(['geeks.created_at' => SORT_DESC])
            ->all();

        // Find geeks that we liked
        $likes = Likes::getUserLikes(Yii::$app->user->id);

        return $this->render('all', [
            'geeks' => $geeks,
            'likes' => $likes
        ]);
    }

    /**
     * Ajax like
     *
     * @return array
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionLike()
    {

        if (Yii::$app->request->isAjax) {
            $like = new Likes();
            $geek_id = Yii::$app->request->post('id');

            if (Geeks::findOne($geek_id) === null) {
                throw new NotFoundHttpException;
            }

            if (Likes::isRelationExist(Yii::$app->user->id, $geek_id)) {
                Likes::find()->where(['user_id' => Yii::$app->user->id, 'geek_id' => $geek_id])->one()->delete();
                $option = 'delete';
            } else {
                $like->user_id = Yii::$app->user->id;
                $like->geek_id = $geek_id;
                $like->save();
                $option = 'add';
            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            $count = Likes::find()->where(['geek_id' => $geek_id])->count();

            return ['status' => 'success', 'option' => $option, 'count' => $count];
        }

    }

    /**
     * Answer to the geek by modal form
     *
     * @return array|string
     */
    public function actionAnswer()
    {
        $model = new GeekForm();

        if ($model->load(Yii::$app->request->post())) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->save()) {
                $status = 'Успех';
            } else {
                $status = 'Неудача';
            }

            return ['status' => $status];

        } else if (Yii::$app->request->isAjax) {

            $model->parent_id = Yii::$app->request->post('id');
            return $this->renderAjax('answer', [
                'model' => $model,
            ]);
        }
    }

}
