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

## Установка
```bash
  composer install #установка пакетов
  php yii migrate #выполнение миграций
  php yii migrate --migrationPath=@yii/rbac/migrations/ #выполнение миграций RBAC
  php yii rbac/init #инициализация ролей
```

## Разметка
Используется [twig](https://twig.symfony.com/).
