<?php

$name = file_exists(__DIR__ . '/app/app.name.php') ? file_get_contents(__DIR__ . '/app/app.name.php') : '';
$adminEmail = file_exists(__DIR__ . '/app/app.admin.email.php') ? file_get_contents(__DIR__ . '/app/app.admin.email.php') : '';
$senderEmail = file_exists(__DIR__ . '/app/app.sender.email.php') ? file_get_contents(__DIR__ . '/app/app.sender.email.php') : '';

return [
    'name' => $name ?: 'Моя компания',
    'adminEmail' => $adminEmail,
    'senderEmail' => $senderEmail,
    'senderName' => $name ?: 'Моя компания',
];