<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use \common\models\Specializations;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Специальности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specializations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить специальность', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'created_at',
            'updated_at',
            /*[
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Specializations $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                  }
            ],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'contentOptions' => ['class' => 'action-column'],
                'buttons' => [


                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-eye"></span>', $url, [
                            'title' => Yii::t('yii', 'Просмотр'),
                            'data-toggle'=>'tooltip',
                            'class'=>'btn btn-sm btn-success'
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-magic"></span>', $url, [
                            'title' => Yii::t('yii', 'Редактировать'),
                            'data-toggle'=>'tooltip',
                            'class'=>'btn btn-sm btn-primary'
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="fa fa-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Удалить'),
                                'data-toggle' => 'tooltip',
                                'class' => 'btn btn-sm btn-danger',
                                'data' => ['confirm' => 'Вы уверены что хотите удалить пользователя?'],
                            ]);

                    },
                ],
            ]
        ],
    ]); ?>


</div>
