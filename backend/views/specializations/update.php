<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Specializations */

$this->title = 'Update Specializations: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Specializations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="specializations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
