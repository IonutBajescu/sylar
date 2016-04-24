Sylar - Intrusion Detection System
================
[![Latest Version](https://img.shields.io/packagist/v/ionut/sylar.svg?style=flat-square)](https://github.com/IonutBajescu/sylar/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/IonutBajescu/sylar/master.svg?style=flat-square)](https://travis-ci.org/IonutBajescu/sylar)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/IonutBajescu/sylar.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/sylar/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/IonutBajescu/sylar.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/sylar)
[![Total Downloads](https://img.shields.io/packagist/dt/ionut/sylar.svg?style=flat-square)](https://packagist.org/packages/ionut/sylar)

Sylar is a framework-agnostic IDS - Intrusion Detection System implementing PSR-7 and PSR-3. It also has a fancy dashboard.

## Installation
`composer require ionut/sylar`

## Quickstart
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

## Dashboard
Although not publicly released yet, it's important to state that Sylar will have a nice dashboard hopefully at the end of May.
![](http://i.imgur.com/4NEL2F0.png)

## Frameworks
Adapters for ease of use in frameworks haven't been written yet. If time is short please use the standalone example from the Quickstart section, it works no matter what framework you use / don't use.

License
---------------------

The Sylar library is open-sourced software licensed under the MIT license.
