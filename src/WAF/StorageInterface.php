<?php namespace Ionut\Sylar\WAF;


interface StorageInterface {

	public function exists($row);

	public function add($row);

	public function remove($row);

	public function clear();
} 