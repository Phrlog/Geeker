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
use yii\db\Query;
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
                'only' => ['index', 'geeks', 'create', 'view', 'feed'],
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'geeks', 'view', 'feed'],
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
        $query = new Query;
        $query->select('subscribe_id')
            ->from('subscription')
            ->where(['user_id' => Yii::$app->user->id]);
        $users = $query->all();

        $query = 'user_id=' . Yii::$app->user->id;
        for ($i = 0; $i < count($users); ++$i){
            $query.= ' OR user_id=' . $users[$i]['subscribe_id'];
        }

        $geeks = Geeks::find()->where($query)->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('all',[
            'geeks' => $geeks
        ]);
    }

}
