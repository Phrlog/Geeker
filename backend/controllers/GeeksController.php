<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Geeks;
use common\models\GeekForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class AdminController extends Controller
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

    /**
     * Create geek with current time
     *
     * @return string
     */
    public function actionCreateDateGeek()
    {
        $geek = new Geeks();

        $time = date("H:i:s");

        $geek->text = $time;
        $result = $geek->save() ? "Твит с текстом $time успешно опубликован!" : "Неудача! Попробуйте снова.";

        return $this->render('create-date-geek',[
            'result' => $result
        ]);
    }

    public function actionCreateGeek()
    {
        $model = new GeekForm();
        $text = Yii::$app->request->post('GeekForm')['text'];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $geek = new Geeks();
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

        return $this->render('create-geek', [
            'model'  => $model,
        ]);
    }

    public function actionShowGeeks()
    {
        $geeks = new Geeks();
        $geeks = $geeks->find()->all();

        return $this->render('show-geeks',[
            'geeks' => $geeks
        ]);
    }

    public function actionEditGeek($id)
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

        return $this->render('edit-geek', [
            'model'  => $model
        ]);
    }

    public function actionDeleteGeek($id)
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
