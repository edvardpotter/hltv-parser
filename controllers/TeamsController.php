<?php

namespace app\controllers;

use app\entities\Players;
use app\models\CreateTeam;
use app\models\Parser;
use Yii;
use app\entities\Teams;
use yii\helpers\ArrayHelper;
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
        $model = new CreateTeam();

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            $result = 'Ссылка добавлена: ' . Url::to(['view', 'id' => $model->getEntity()->id], true);
            Yii::$app->session->addFlash('success', $result);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Получает информацию
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        return ArrayHelper::toArray($model, [
            Teams::class => [
                'maps_played',
                'wins_draws_losses',
                'total_kills',
                'total_deaths',
                'rounds_played',
                'kd_ratio',
                'players' => function (Teams $team) {
                    return ArrayHelper::toArray($team->players, [
                        Players::class => [
                            'player',
                            'kd_diff',
                            'kd'
                        ]
                    ]);
                },
            ],
        ]);
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
