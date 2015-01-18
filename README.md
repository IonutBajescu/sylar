Sylar - Intrusion Detection System
================
[![Latest Version](https://img.shields.io/packagist/v/ionut/sylar.svg?style=flat-square)](https://github.com/IonutBajescu/securitylistener/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/IonutBajescu/securitylistener/master.svg?style=flat-square)](https://travis-ci.org/IonutBajescu/securitylistener)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/IonutBajescu/securitylistener.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/securitylistener/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/IonutBajescu/securitylistener.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/securitylistener)
[![Total Downloads](https://img.shields.io/packagist/dt/ionut/sylar.svg?style=flat-square)](https://packagist.org/packages/ionut/sylar)

The Sylar package is an open source `Web Application Firewall` && `Intrusion Detection System`.

An example of Sylar usage as a Web Application Firewall:
```php
<?php
require 'securitylistener/vendor/autoload.php';

use Ionut\Sylar\Listener;
use Ionut\Sylar\WAF\Exceptions\BlockedIpException;
$listener = Listener::factory();
try{
	$listener->listen();
} catch(BlockedIpException $e){
	exit('Sorry, your IP is blocked by our WAF :(');
}

echo 'this code is protected from evil guys';
```


### Installation method
You can install the Sylar package through composer, run the following command:
`composer require ionut/sylar:*`


License
---------------------

The SecurityListener library is open-sourced software licensed under the MIT license.
