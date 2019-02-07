<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\entities\Teams */

$this->title = Yii::t('app', 'Добавить ссылку');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="teams-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
