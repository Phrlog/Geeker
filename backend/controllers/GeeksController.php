<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Geeks;
use common\models\GeekForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
        ];
    }

    public function actionIndex()
    {
        return $this->actionGeeks();
    }

    public function actionGeeks()
    {
        $geeks = new Geeks();
        $geeks = $geeks->find()->all();

        return $this->render('show-geeks',[
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
                $geek->image = 'uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $geek->thumbnail = 'uploads/thumbnail/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
            }

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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
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

        return $this->redirect(["geeks"]);
    }

}
