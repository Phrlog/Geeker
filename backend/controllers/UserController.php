<?php
namespace backend\controllers;

use common\models\Geeks;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
use yii\filters\VerbFilter;

/**
 * Site controller
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
                'only' => ['index' ,'users', 'show', 'ban'],
                'rules' => [
                    [
                        'actions' => ['index' ,'users', 'show', 'ban'],
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
        return $this->actionUsers();
    }

    public function actionUsers()
    {
        $users = new User();
        $users = $users->find()->all();

        return $this->render('show-users',[
            'users' => $users
        ]);
    }

    public function actionBan($id)
    {
        $user = new User();

        $user = $user->findOne($id);

        if ($user === null) {
            throw new NotFoundHttpException;
        }

        $user->status = 0;

        Geeks::deleteAll(['user_id' => $user->id]);

        return $this->redirect(["users"]);
    }

    public function actionShow()
    {

    }

}
