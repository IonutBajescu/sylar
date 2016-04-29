Sylar - Intrusion Detection System
================
[![Latest Version](https://img.shields.io/packagist/v/ionut/sylar.svg?style=flat-square)](https://github.com/IonutBajescu/sylar/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/IonutBajescu/sylar/master.svg?style=flat-square)](https://travis-ci.org/IonutBajescu/sylar)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/IonutBajescu/sylar.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/sylar/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/IonutBajescu/sylar.svg?style=flat-square)](https://scrutinizer-ci.com/g/IonutBajescu/sylar)
[![Total Downloads](https://img.shields.io/packagist/dt/ionut/sylar.svg?style=flat-square)](https://packagist.org/packages/ionut/sylar)

What's the deal with video cameras? If the intruder is quick enough you might as well never find him.

Then why do people bother to install them? The truth hides behind finding common breaches and identifying areas that are a common target for intruders.

Sylar is like a video camera for your website, but better - it only records the requests that look like might harm your website. It doesn't block them nor remove the harmful characters - its only job is to show you areas of the website that are commonly tried to be breached by hackers .

Under the hood, it digests PSR-7 Requests and logs everything into PSR-3 Loggers, it follows BDD and the code is formatted based on the PSR-2 standard.

And it also has a nice dashboard that provides you in real-time with useful statistics about the latest attempted intrusions on your website.

## Installation
`composer require ionut/sylar`

## Quickstart
```php
<?php
use Ionut\Sylar\Integrations\Standalone;

$sylar = new Standalone('path/to/your.log');
$sylar->run();
```

## Dashboard
Although not publicly released yet, it's important to state that Sylar will have a nice dashboard, hopefully, at the end of May.
![](http://i.imgur.com/NRk2iZE.png)

## Frameworks
Adapters for ease of use in frameworks haven't been written yet. If time is short please use the standalone example from the Quickstart section, it works no matter what framework you use / don't use.

License
---------------------

The Sylar library is open-sourced software licensed under the MIT license.
