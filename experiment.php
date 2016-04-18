<?php

use Zend\Diactoros\ServerRequestFactory;

require 'vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();
var_dump($request);
//var_dump($request->getBody()->getContents());
//echo (serialize($request));
