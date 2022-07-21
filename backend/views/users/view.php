<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'email:email',
            'phone',
            'organization_id',
            'post',
            //'type_org'

        ],
    ]) ?>

    <?php if(Yii::$app->user->can('admin')){?>
        <br>
        <h3>Устройства пользователя: </h3>
        <?= GridView::widget([
            'dataProvider' => $user_device,
            'options' => [
                'class' => 'table-responsive',
            ],
            'columns'=> [
                [
                    'attribute'=>'type_device',
                    'label' => 'Тип устройства'
                ],
                [
                    'attribute'=>'browser',
                    'label' => 'Браузер'
                ],
                [
                    'attribute'=>'os',
                    'label' => 'Операционная система и версия'
                ],
                [
                    'attribute'=>'ver_browser',
                    'label'=>'Версия браузера'
                ],
                [
                    'attribute'=>'processor',
                    'label'=>'Процессор'
                ],
                /*[
                    'attribute'=>'server_user_agent',
                    'label'=>'Агент'
                ],*/
                [
                    'attribute'=>'created_at',
                    'label'=>'Дата входа с устройства',
                    'value'=> function($model){
                        return date('d.m.Y H:i', strtotime($model->created_at));
                    }
                ],
            ]
        ]); ?>
    <? } ?>

</div>
