<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;
use \common\models\AuthItem;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$roles = AuthItem::find()->where(['name' => ['doctor', 'head_doctor', 'reception']])->all();
$roles_item = ArrayHelper::map($roles, 'name', 'description');
?>

<div class="row">
    <div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['value'=> $model->username]); ?>
            
            <?= $form->field($model, 'phone')->widget(MaskedInput::className(),['mask'=>'+7-(999)-999-99-99','clientOptions' => ['removeMaskOnSubmit' => true]])->textInput(['placeholder'=>'+7-(999)-999-99-99']);?>

            <?= $form->field($model, 'email')->textInput(['value'=> $model->email]); ?>

            <?= $form->field($model, 'role')->dropDownList($roles_item); ?>
            
            <?= $form->field($model, 'password')->textInput()->label('Пароль'); ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
