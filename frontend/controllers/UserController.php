<?php
namespace frontend\controllers;

use common\models\Geeks;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
use yii\filters\VerbFilter;
use common\models\Subscription;
use yii\db\Query;

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
                'only' => ['index' ,'all', 'profile', 'friends', 'my-profile', 'subscribe', 'unsubscribe'],
                'rules' => [
                    [
                        'actions' => ['index' ,'all', 'profile', 'friends', 'my-profile', 'subscribe', 'unsubscribe' ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index' ,'all', 'profile'],
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

    public function actionIndex()
    {
        return $this->redirect('users/all');
    }

    public function actionAll()
    {
        $users = new User();
        $users = $users->find()->all();

        return $this->render('all',[
            'users' => $users
        ]);
    }

    public function actionFriends()
    {
        $query = new Query;
        $query->select('subscribe_id')
            ->from('subscription')
            ->where(['user_id' => Yii::$app->user->id]);
        $users = $query->all();

        if (count($users) > 1) {
            $query = 'id=' . $users[0]['subscribe_id'];
            for ($i = 1; $i < count($users); $i++){
                $query.= ' OR id=' . $users[$i]['subscribe_id'];
            }
        } elseif (count($users) == 1) {
            $query = 'id=' . $users[0]['subscribe_id'];
        } else {
            return $this->redirect('users/all');
        }

        $users = User::find()->where($query)->all();

        return $this->render('all',[
            'users' => $users
        ]);

    }

    public function actionProfile($id)
    {
        if (Yii::$app->user->id == $id) {
            return $this->redirect(['user/my-profile']);
        }

        $user = User::findOne(['id' => $id]);

        $sub_me = Subscription::find()->where(['subscribe_id' => $id])->count();
        $sub_to = Subscription::find()->where(['user_id' => $id])->count();

        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $user_geeks = Geeks::findAll(['user_id' => $id]);

        return $this->render('profile',[
            'geeks' => $user_geeks,
            'user' => $user,
            'me' => $sub_me,
            'to' => $sub_to
        ]);
    }

    public function actionMyProfile()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $sub_me = Subscription::find()->where(['subscribe_id' => Yii::$app->user->id])->count();
        $sub_to = Subscription::find()->where(['user_id' => Yii::$app->user->id])->count();

        $user_geeks = Geeks::findAll(['user_id' => Yii::$app->user->id]);

        return $this->render('my-profile',[
            'geeks' => $user_geeks,
            'user' => $user,
            'me' => $sub_me,
            'to' => $sub_to
        ]);
    }

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

        $this->redirect(['user/profile', 'id' => $id]);
    }

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

        $this->redirect(['user/profile', 'id' => $id]);
    }

}
