Sylar - Intrusion Detection System
================
[![Latest Version](https://img.shields.io/packagist/v/ionut/sylar.svg?style=flat-square)](https://github.com/IonutBajescu/sylar/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/IonutBajescu/sylar/master.svg?style=flat-square)](https://travis-ci.org/IonutBajescu/sylar)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/IonutBajescu/sylar.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/sylar/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/IonutBajescu/sylar.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/sylar)
[![Total Downloads](https://img.shields.io/packagist/dt/ionut/sylar.svg?style=flat-square)](https://packagist.org/packages/ionut/sylar)

Sylar is a framework-agnostic IDS - Intrusion Detection System. It supports PSR-7 requests and PSR-3 loggers.

## Installation
`composer require ionut/sylar`

## Usage
```php
<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Ionut\Sylar\Reactor;

// $logger can be whatever logger you prefer as long as it adheres to PSR-3.
// Our recommended choice would be Monolog.
$logger = new Logger('ids');
$logger->pushHandler(new StreamHandler('path/to/your.log'));

$sylar = Reactor::factory($logger);
// $request has to be passed by your framework of choice.
$sylar->digest($request);
```

## Symfony
http://symfony.com/doc/current/cookbook/psr7.html

## Laravel
https://laravel.com/docs/5.1/requests#psr7-requests

## Standalone applications
We respect people's decisions of not using any framework. Fortunately for you Sylar is not tied to any framework, all it needs is a PSR-7 compatible request and it works!

If you want to use Sylar in a standalone application you might want to check out [zend-diactoros](https://github.com/zendframework/zend-diactoros)

License
---------------------

The Sylar library is open-sourced software licensed under the MIT license.
