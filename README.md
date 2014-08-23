Security Listener - WAF
================
[![Build Status](https://img.shields.io/travis/IonutBajescu/securitylistener.svg)](https://travis-ci.org/IonutBajescu/securitylistener)
[![Total Downloads](https://img.shields.io/packagist/dt/ionut/securitylistener.svg)](https://packagist.org/packages/ionut/securitylistener)
[![Latest Version](http://img.shields.io/packagist/v/ionut/securitylistener.svg)](https://packagist.org/packages/ionut/securitylistener)
[![Dependency Status](https://www.versioneye.com/php/ionut:securitylistener/badge.svg)](https://www.versioneye.com/php/ionut:securitylistener)

SecurityListener is an open source `Web Application Firewall`.

Little example:
```php
<?php
require 'securitylistener/vendor/autoload.php';

use Ionut\SecurityListener\Listener;
use Ionut\SecurityListener\WAF\Exceptions\BlockedIpException;
$listener = Listener::factory();
try{
	$listener->listen();
} catch(BlockedIpException $e){
	exit('Sorry, your IP is blocked by our WAF :(');
}

echo 'code protected from evil guys';
```


License
---------------------

The SecurityListener library is open-sourced software licensed under the MIT license.