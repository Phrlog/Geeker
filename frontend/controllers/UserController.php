<?php
namespace frontend\controllers;

use common\models\Geeks;
use common\models\SearchForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
use yii\filters\VerbFilter;
use common\models\Subscription;
use common\models\Likes;
use common\models\SettingsForm;

/**
 * User controller
 */
class UserController extends Controller
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
                'only' => ['index', 'all', 'profile', 'friends', 'my-profile', 'subscribe', 'unsubscribe'],
                'rules' => [
                    [
                        'actions' => ['index', 'all', 'profile', 'friends', 'my-profile', 'subscribe', 'unsubscribe'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'all', 'profile'],
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
     * Redirect to actionAll
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect('users/all');
    }

    /**
     * Display all users
     *
     * @return string
     */
    public function actionAll()
    {
        $title = 'Все пользователи';

        $users = User::getUsersById(true);

        return $this->render('all', [
            'users' => $users,
            'title' => $title
        ]);
    }

    /**
     * Display subscriptions and subscribers
     *
     * @return string
     */
    public function actionFriends()
    {
        // Get $subscriptions of current user
        $param = ['select' => 'subscribe_id', 'where' => 'user_id'];
        $id = User::getUsersId(Yii::$app->user->id, $param);
        $subscriptions = User::getUsersById($id);

        // Get $subscribers of current user
        $param = ['select' => 'user_id', 'where' => 'subscribe_id'];
        $id = User::getUsersId(Yii::$app->user->id, $param);
        $subscribers = User::getUsersById($id);

        return $this->render('friends', [
            'subscriptions' => $subscriptions,
            'subscribers' => $subscribers
        ]);

    }

    /**
     * Display user profile
     *
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionProfile($id)
    {
        if (Yii::$app->user->id == $id) {
            return $this->redirect(['user/my-profile']);
        }

        $user = User::findOne(['id' => $id]);
        if ($user === null) {
            throw new NotFoundHttpException;
        }

        // Find subscriptions and subscribers
        $sub_me = Subscription::find()->where(['subscribe_id' => $id])->count();
        $sub_to = Subscription::find()->where(['user_id' => $id])->count();

        // Find geeks that we liked
        $likes = Likes::getUserLikes(Yii::$app->user->id);

        // Find user geeks
        $geeks = Geeks::getUserGeeks($id);

        return $this->render('profile', [
            'geeks' => $geeks,
            'user' => $user,
            'me' => $sub_me,
            'to' => $sub_to,
            'likes' => $likes
        ]);
    }

    /**
     * Display your profile
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionMyProfile()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if ($user === null) {
            throw new NotFoundHttpException;
        }

        // Find subscriptions and subscribers
        $sub_me = Subscription::find()->where(['subscribe_id' => Yii::$app->user->id])->count();
        $sub_to = Subscription::find()->where(['user_id' => Yii::$app->user->id])->count();

        // Find geeks that we liked
        $geeks = Geeks::getUserGeeks(Yii::$app->user->id);

        // Find geeks that we liked
        $likes = Likes::getUserLikes(Yii::$app->user->id);

        return $this->render('my-profile', [
            'geeks' => $geeks,
            'user' => $user,
            'me' => $sub_me,
            'to' => $sub_to,
            'likes' => $likes
        ]);
    }


    /**
     * Subscribe to user by id
     *
     * TODO ajax subscribe
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSubscribe($id)
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $subscribe = User::findOne(['id' => $id]);
        if ($subscribe === null) {
            throw new NotFoundHttpException;
        }

        $sub = new Subscription();

        if (!Subscription::isRelationExist($user->id, $subscribe->id)) {
            $sub->user_id = $user->id;
            $sub->subscribe_id = $subscribe->id;
            $sub->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Unsubscribe to user by id
     *
     * TODO ajax subscribe
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUnsubscribe($id)
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $subscribe = User::findOne(['id' => $id]);
        if ($subscribe === null) {
            throw new NotFoundHttpException;
        }

        $sub = new Subscription();

        if ($sub::isRelationExist($user->id, $subscribe->id)) {
            $sub->findOne(['user_id' => Yii::$app->user->id, 'subscribe_id' => $id])->delete();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * User subscribers by id
     *
     * @param $id
     * @return string
     */
    public function actionSubscribers($id)
    {
        $title = 'Подписчики пользователя ' . User::find()->select(['username'])->where(['id' => $id])->one()->username;

        $param = ['select' => 'user_id', 'where' => 'subscribe_id'];
        $all_id = User::getUsersId($id, $param);
        $subscribers = User::getUsersById($all_id);

        return $this->render('all', [
            'users' => $subscribers,
            'title' => $title
        ]);
    }

    /**
     * User subscriptions by id
     *
     * @param $id
     * @return string
     */
    public function actionSubscriptions($id)
    {
        $title = 'Подписки пользователя ' . User::find()->select(['username'])->where(['id' => $id])->one()->username;

        $param = ['select' => 'subscribe_id', 'where' => 'user_id'];
        $all_id = User::getUsersId($id, $param);
        $subscriptions = User::getUsersById($all_id);

        return $this->render('all', [
            'users' => $subscriptions,
            'title' => $title
        ]);
    }

    public function actionSearch()
    {
        if (Yii::$app->request->isPost) {
            $user = User::find()->where(['username' => Yii::$app->request->post('SearchForm')['username']])->one();
            if ($user === null) {
                throw new NotFoundHttpException;
            } else {
                $this->redirect(['user/profile', 'id' => $user->id]);
            }
        }
        $users = User::find()
            ->select(['username as value', 'username as label'])
            ->asArray()
            ->all();
        $model = new SearchForm();

        return $this->render('search', [
            'users' => $users,
            'model' => $model
        ]);
    }

    public function actionSettings()
    {
        $model = new SettingsForm();

        $user = User::findOne(['id' => Yii::$app->user->id]);

        $model->username = $user->username;
        $model->email = $user->email;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $result = "Настройки успешно сохранены";
                $alert_type = 'success';
            } else {
                $result = "Неудача! Попробуйте снова";
                $alert_type = 'error';
            }
            Yii::$app->session->setFlash($alert_type, $result);
        }

        return $this->render('settings', [
            'model' => $model,
            'user' => $user
        ]);
    }

}
