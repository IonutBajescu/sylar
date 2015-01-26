<?php

use Ionut\Sylar\Guardian as SecurityListener;
use Mockery as m;

class BlockerTest extends PHPUnit_Framework_TestCase {

	public function testBasic()
	{
		$this->setExpectedException('Ionut\Sylar\WAF\Exceptions\BlockedIpException');

		$config = include __DIR__ . '/../../src/config.php';
		$config['receivers']['blocker'] =
			[
				'min_gravity' => 1
			];

		$listener         = new SecurityListener($this->mockInput(['sql' => "-1 order by 6-- -"]));
		$listener->setConfig($config);
		$listener->waf->setIp(microtime());

		$listener->listen();
	}

	public function mockInput(array $input = array())
	{
		$mock = $this->getMock('Ionut\\Sylar\\Request');
		$mock->expects($this->any())->method('getDataForTesting')->will($this->returnValue($input));

		return $mock;
	}

	public function testWithoutException()
	{
		$config                         = include __DIR__ . '/../../src/config.php';
		$config['receivers']['blocker'] =
			[
				'min_gravity' => 1
			];

		$listener         = new SecurityListener($this->mockInput(['sql' => "this is a normal string"]));
		$listener->setConfig($config);
		$listener->waf->setIp(microtime());

		$listener->listen();
	}

	public function tearDown()
	{
		$storage = new \Ionut\Sylar\WAF\Storage();
		$storage->clear();
	}
}
