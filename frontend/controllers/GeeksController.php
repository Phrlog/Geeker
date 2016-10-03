<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Geeks;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\GeekForm;
use yii\web\UploadedFile;
use common\models\User;
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
                'only' => ['index', 'geeks', 'create', 'view', 'feed', 'like'],
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'geeks', 'view', 'feed', 'like'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'geeks', 'view', 'like'],
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

    public function beforeAction($action)
    {
        if ($action->id == 'like') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect('geeks/all');
    }

    public function actionAll()
    {
        $geeks = new Geeks();
        $geeks = $geeks->find()->all();

        return $this->render('all',[
            'geeks' => $geeks
        ]);
    }

    public function actionView($id)
    {
        $geek = new Geeks();
        $geek = $geek->findOne($id);

        if ($geek === null) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', [
            'geek' => $geek,
        ]);
    }

    public function actionCreate()
    {
        $model = new GeekForm();
        $text = Yii::$app->request->post('GeekForm')['text'];

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            $geek = new Geeks();

            if ($model->upload()) {
                $path = 'upload/' . Yii::$app->user->id;

                $geek->image = $path . '/original/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $geek->thumbnail = $path . '/thumbnail/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
            }


            $geek->user_id = Yii::$app->user->id;
            $geek->text = $text;

            if ($geek->save()) {
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
            'model'  => $model,
        ]);
    }

    public function actionFeed()
    {
        $user = new User();
        $param= ['select' => 'subscribe_id', 'where' => 'user_id'];
        $users_id = $user->getUsersId(Yii::$app->user->id, $param);
        $query = $user->makeUsersQuery($users_id, $param);

        $geeks = $query == null ? [] : Geeks::find()->where($query)->orWhere(['user_id' => Yii::$app->user->id ])->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('all',[
            'geeks' => $geeks
        ]);
    }

    public function actionLike()
    {

        if (Yii::$app->request->isAjax)
        {
            $like = new Likes();
            $geek_id = Yii::$app->request->post('id');

            if (Geeks::findOne($geek_id) === null) {
                throw new NotFoundHttpException;
            }

            if (Likes::isRelationExist(Yii::$app->user->id, $geek_id)){
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

}
