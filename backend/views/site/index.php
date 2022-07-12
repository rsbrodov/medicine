<?php

/** @var yii\web\View $this */

$this->title = 'Администрирование';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Главная</h1>
        <?=Yii::$app->user->id?>
    </div>
</div>
