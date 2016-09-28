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
                'only' => ['index', 'geeks', 'create', 'view'],
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'geeks', 'view'],
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
        return $this->actionGeeks();
    }

    public function actionGeeks()
    {
        $geeks = new Geeks();
        $geeks = $geeks->find()->all();

        return $this->render('geeks',[
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


}
