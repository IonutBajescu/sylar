<?php namespace Ionut\SecurityListener\WAF;


interface StorageInterface {

	public function exists($row);

	public function add($row);

	public function remove($row);
} 