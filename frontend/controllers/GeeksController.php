<?php
namespace frontend\controllers;

use Yii;
use frontend\models\FrontendUser;
use frontend\models\FrontendGeeks;
use yii\web\Controller;
use common\models\Geeks;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\GeekForm;
use common\models\Likes;
use yii\web\Response;

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
        $geeks = Geeks::getGeeks(SORT_DESC);
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
        $geek = Geeks::getGeekById($id);
        $answers = Geeks::getGeeks(SORT_DESC, ['parent_id' => $id]);
        $likes = Likes::getUserLikes(Yii::$app->user->id);

        return $this->render('view', [
            'geek' => $geek,
            'answers' => $answers,
            'likes' => $likes
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
        $all_id = FrontendUser::getUsersId(Yii::$app->user->id, $param);

        // Find geeks of your subscriptions for live search
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
        $geeks = FrontendGeeks::getUserFeed(Yii::$app->user->id, SORT_DESC);

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
            $geek_id = Yii::$app->request->post('id');
            $option = Likes::doLike(Yii::$app->user->id, $geek_id);
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

        return null;
    }

}
