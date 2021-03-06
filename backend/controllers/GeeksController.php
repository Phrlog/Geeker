<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Geeks;
use common\models\GeekForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\models\User;
use yii\filters\VerbFilter;

/**
 * Site controller
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
                'only' => ['index', 'all', 'create', 'create-date-geek', 'edit', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'all', 'create', 'create-date-geek', 'edit', 'delete'],
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

    /**
     * Create geek with current time
     *
     * @return string
     */
    public function actionCreateDateGeek()
    {
        $geek = new Geeks();

        date_default_timezone_set('europe/moscow');
        $time = date("H:i:s");

        $geek->user_id = Yii::$app->user->id;

        $geek->text = $time;
        $result = $geek->save() ? "Твит с текстом $time успешно опубликован!" : "Неудача! Попробуйте снова.";

        return $this->render('create-date-geek',[
            'result' => $result
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

    public function actionEdit($id)
    {
        $geek = new Geeks();
        $geek = $geek->findOne($id);

        if ($geek === null) {
            throw new NotFoundHttpException;
        }

        $model = new GeekForm();
        $text = Yii::$app->request->post('GeekForm')['text'];

        $model->text = $geek->text;
        if ($model->load(Yii::$app->request->post())) {
            
            $geek->text = $text;

            if ($geek->save()) {
                $result = "Твит успешно изменен";
                $alert_type = 'success';
            } else {
                $result = "Неудача! Попробуйте снова";
                $alert_type = 'error';
            }

            Yii::$app->session->setFlash($alert_type, $result);

            return $this->refresh();
        }

        return $this->render('edit', [
            'model'  => $model
        ]);
    }

    public function actionDelete($id)
    {
        $geek = new Geeks();

        $geek = $geek->findOne($id);

        if ($geek === null) {
            throw new NotFoundHttpException;
        }

        $geek->delete();

        return $this->redirect(["geeks/all"]);
    }

}
