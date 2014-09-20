<?php
use Ionut\SecurityListener\Listener as SecurityListener;
use Mockery as m;

class LogTest extends PHPUnit_Framework_TestCase {

	public function testBasicLog()
	{
		$config = (object)[
			'receivers' => [
				'log' => [
					'to' => dirname(dirname(__DIR__)).'/data/logs.txt'
				]
			]
		];
		$listener = m::mock('\\Ionut\\SecurityListener\\Listener');
		$listener->config = $config;

		$log = new Ionut\SecurityListener\Receivers\Log($listener);

		$filter = new \Ionut\SecurityListener\Filters\Listener\Filter(null, null, null, null);
		$alert = new \Ionut\SecurityListener\Alert($filter, null, null);
		$this->assertTrue($log->call($alert));
	}

	public function testLogWhenSomeoneTestSecurity()
	{
		$vectors = ["Hello'", '-1 order by 6-- -'];

		$logFile = dirname(dirname(__DIR__)).'/data/logs.txt';

		$lastContent = file_get_contents($logFile);
		foreach($vectors as $vector){
			$request = $this->mockInput([$vector]);
			$SL      = new SecurityListener($request);
			$SL->config->receivers['log'] = ['to' => $logFile];
			$SL->listen();

			$this->assertNotEquals($lastContent, $lastContent = file_get_contents($logFile));
		}

	}

	public function mockInput(array $input = array())
	{
		$mock = $this->getMock('Ionut\\SecurityListener\\Request');
	    $mock->expects($this->any())->method('getDataForTesting')->will($this->returnValue($input));
		return $mock;
	}
}
