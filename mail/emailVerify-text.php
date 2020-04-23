<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Добрый день!

Email <?= $user->username ?> был указан для регистрации в системе детского центра "Счастье"
Перейдите по ссылке для подтверждения вашего email:
<?= $verifyLink ?>