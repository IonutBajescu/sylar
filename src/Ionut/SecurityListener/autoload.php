<?php

$base = dirname(dirname(dirname(__DIR__)));

if (file_exists($file = $base . '/vendor/autoload.php')) {
	include $file;
} elseif (file_exists($file = $base . '/vendor/autoload.php')) {
	include $file;
} else {
	throw new Exception("You don't have an autoload.");

}
