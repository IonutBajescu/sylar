Sylar - Intrusion Detection System
================
[![Latest Version](https://img.shields.io/packagist/v/ionut/sylar.svg?style=flat-square)](https://github.com/IonutBajescu/sylar/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/IonutBajescu/sylar/master.svg?style=flat-square)](https://travis-ci.org/IonutBajescu/sylar)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/IonutBajescu/sylar.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/sylar/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/IonutBajescu/sylar.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/sylar)
[![Total Downloads](https://img.shields.io/packagist/dt/ionut/sylar.svg?style=flat-square)](https://packagist.org/packages/ionut/sylar)


Sylar is an open source `Intrusion Detection System` that in some cases might be configured to act as an `Web Application Firewall`.

Since version 0.8 it only supports Laravel 5!

An example of instantiating a basic WAF:
```php
<?php
require 'vendor/autoload.php';

use Ionut\Sylar\Guardian;
use Ionut\Sylar\WAF\Exceptions\BlockedIpException;
$guardian = new Guardian;
try{
	$guardian->listen();
} catch(BlockedIpException $e){
	exit('Sorry, your IP was blocked by our WAF!');
}

echo 'this page is protected from evil guys';
```


### Installation method
The recommended method is through composer, with the following command:
`composer require ionut/sylar`


License
---------------------

The Sylar library is open-sourced software licensed under the MIT license.
