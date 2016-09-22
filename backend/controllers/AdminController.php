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
    public $defaultAction = 'create-geek';
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
        $result = null;
        $model = new GeekForm();
        $text = Yii::$app->request->post('GeekForm')['text'];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $geek = new Geeks();
            $geek->text = $text;
            $result = $geek->save() ? "Твит с текстом $text успешно опубликован!" : "Неудача! Попробуйте снова.";
        }

        return $this->render('create-geek', [
            'model'  => $model,
            'result' => $result
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

        $result = null;
        $model = new GeekForm();
        $text = Yii::$app->request->post('GeekForm')['text'];

        $model->text = $geek->text;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $geek->text = $text;
            $result = $geek->save() ? "Твит успешно изменен" : "Неудача! Попробуйте снова.";
        }

        return $this->render('edit-geek', [
            'model'  => $model,
            'result' => $result
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
