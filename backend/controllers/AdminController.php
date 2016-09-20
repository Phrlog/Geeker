<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Geeks;
use common\models\GeekForm;

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
}
