<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Personal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form bg-white mg-bottom">

    <h3>Данные компании</h3>
    <p>Название будет выведено в левом верхнем углу</p><hr />
    
    <?php $form = ActiveForm::begin(); ?>

    <div class="d-flex">

        <div class="u-info-block">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($company, 'name')->textInput(['maxlength' => true])->label(Yii::t('app', 'Company name')) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($company, 'count_people')->textInput(['maxlength' => true])->label(Yii::t('app', 'Company count people')) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($company, 'open_year')->textInput(['maxlength' => true])->label(Yii::t('app', 'Company open year')) ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
