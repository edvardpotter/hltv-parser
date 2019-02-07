<?php

namespace app\controllers;

use app\models\Parser;
use Yii;
use app\entities\Teams;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TeamsController implements the CRUD actions for Teams model.
 */
class TeamsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Creates a new Teams model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Teams();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result = 'Ссылка добавлена: ' . Url::to(['parse', 'id' => $model->id], true);
            Yii::$app->session->addFlash('success', $result);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Получает информацию
     * @param $id
     * @return \app\src\Overview
     * @throws NotFoundHttpException
     */
    public function actionParse($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        return Parser::parse($model);
    }

    /**
     * Finds the Teams model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Teams the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Teams::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запрошенная страница не существует'));
    }
}
