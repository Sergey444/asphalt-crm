<?php 

  $senderEmail = file_exists(__DIR__ . '/app/app.sender.email.php') ? file_get_contents(__DIR__ . '/app/app.sender.email.php') : '';
  $senderPassword = file_exists(__DIR__ . '/app/app.sender.password.php') ? file_get_contents(__DIR__ . '/app/app.sender.password.php') : '';
  $senderPort = file_exists(__DIR__ . '/app/app.sender.port.php') ? file_get_contents(__DIR__ . '/app/app.sender.port.php') : '';
  $senderHost = file_exists(__DIR__ . '/app/app.sender.host.php') ? file_get_contents(__DIR__ . '/app/app.sender.host.php') : '';
  $senderSsl = file_exists(__DIR__ . '/app/app.sender.ssl.php') ? file_get_contents(__DIR__ . '/app/app.sender.ssl.php') : '';

  return [
      'class'      => 'Swift_SmtpTransport',
      'host'       => $senderHost,
      'username'   => $senderEmail,
      'password'   => $senderPassword,
      'port'       => $senderPort,
      'encryption' => $senderSsl,
  ];