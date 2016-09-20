<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Geeks;
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
        $geeks = new Geeks();
        $geeks = $geeks->find()->all();

        return $this->render('index',[
            'geeks' => $geeks
        ]);
    }

}
