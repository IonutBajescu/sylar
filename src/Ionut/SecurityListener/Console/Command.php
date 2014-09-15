<?php namespace Ionut\SecurityListener\Console;

class Command extends \Illuminate\Console\Command {

	protected $config;

	public function __construct()
	{
		parent::__construct();

		$this->config = (object)(include __DIR__ . '/../config.php');
	}
}
