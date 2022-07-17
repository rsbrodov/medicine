<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DoctorsHasSpecializations */

$this->title = 'Create Doctors Has Specializations';
$this->params['breadcrumbs'][] = ['label' => 'Doctors Has Specializations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctors-has-specializations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
