<?php

include 'vendor/autoload.php';

use Ionut\SecurityListener\Listener;
$listener = Listener::factory();
$listener->listen();