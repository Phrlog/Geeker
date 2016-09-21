<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Geeks;
use yii\web\NotFoundHttpException;

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


}
