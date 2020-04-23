<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Personal */

$this->title = Yii::t('app', 'Create Personal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Personals'), 'url' => ['users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-create">
    <div class="bg-white">
        <h3>Страница добавления пользователя</h3><hr />
        <?= $this->render('_form', [
            'model' => $model
        ]) ?>
    </div>
</div>
