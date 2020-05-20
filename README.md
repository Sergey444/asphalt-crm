# Система управления асфальтового завода

## Параметры базы данных
Создать в папке /config/ файл db.php
```bash
<?php

  return [
      'class' => 'yii\db\Connection',
      'dsn' => 'mysql:host=%HOST_NAME%;dbname=%DB_NAME%',
      'username' => '%USER_NAME%',
      'password' => '%PASSWORD%',
      'charset' => 'utf8'
  ];
```

## Параметры SMTP 
Создать в папке /config/ файл mailer.php
```bash
<?php 

  return [
      'class'      => 'Swift_SmtpTransport',
      'host'       => 'smtp.yandex.ru',
      'username'   => 'noreply@my-site.ru',
      'password'   => 'password',
      'port'       => '465',
      'encryption' => 'ssl',
  ];
```

## Установка
```bash
  composer install #установка пакетов
  php yii migrate #выполнение миграций
  php yii migrate --migrationPath=@yii/rbac/migrations/ #выполнение миграций RBAC
  php yii rbac/init #инициализация ролей
```

## Разметка
Используется [twig](https://twig.symfony.com/).
