<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'vendor/autoload.php';

use Ionut\SecurityListener\Listener;
$listener = Listener::factory();
$listener->listen();