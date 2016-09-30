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
                'only' => ['index' ,'users', 'show'],
                'rules' => [
                    [
                        'actions' => ['index' ,'users', 'show'],
                        'allow' => true,
                        'roles' => ['@'],
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

    public function actionProfile($id)
    {
        if (Yii::$app->user->id == $id) {
            return $this->redirect(['user/my-profile']);
        }

        $user = User::findOne(['id' => $id]);

        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $user_geeks = Geeks::findAll(['user_id' => $id]);

        return $this->render('profile',[
            'geeks' => $user_geeks,
            'user' => $user
        ]);
    }

    public function actionMyProfile()
    {

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
