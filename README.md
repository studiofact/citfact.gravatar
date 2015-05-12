Gravatar для 1C-Bitrix
=========

Модуль позволяет вам быстро и легко использовать Gravatar в вашем приложение.

## Требования

 - PHP версия >= 5.3.3
 - Bitrix версия >= 14

## Установка

Создайте или обновите ``composer.json`` файл и запустите ``php composer.phar update``
``` json
  {
      "require": {
          "citfact/gravatar": "dev-master"
      }
  }
```

Подключите composer автолоадер
``` php
// init.php

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
```

## Пример использования

``` php
\Bitrix\Main\Loader::includeModule('citfact.gravatar');
$gravatar = new \Citfact\Gravatar\Gravatar();
$gravatar
    ->setAvatarSize(120)
    // Принимает значения: '404', 'mm' , 'identicon', 'monsterid', 'wavatar', 'retro'
    // Или путь до изображения, по умолчанию false
    ->setDefaultImage(false)
    // Принимает значения: 'g', 'pg', 'r', 'x'
    // По умолчанию 'g'
    ->setMaxRating('g')
    ->setSecureUrl(false); // true или false

var_dump($gravatar->getAvatarSize());
var_dump($gravatar->getDefaultImage());
var_dump($gravatar->getMaxRating());
var_dump($gravatar->getSecureUrl());

// Получаем аватар
echo '<img src="'.$gravatar->get('onexhovia@gmail.com').'" alt="" />';
```
