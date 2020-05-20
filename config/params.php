<?php

$name = file_get_contents(__DIR__ . '/app/app.name.php');
$adminEmail = file_get_contents(__DIR__ . '/app/app.admin.email.php');
$senderEmail = file_get_contents(__DIR__ . '/app/app.sender.email.php');

return [
    'name' => $name ? $name : 'Моя компания',
    'adminEmail' => $adminEmail,
    'senderEmail' => $senderEmail,
    'senderName' => 'ООО "АСФ СИБЦЕНТР"',
];