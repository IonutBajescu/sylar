<?php

use Ionut\SecurityListener\WAF\Manager;
use Mockery as m;

class ManagerTest extends PHPUnit_Framework_TestCase {

	public function testBlockedIp()
	{
		$this->setExpectedException('Ionut\SecurityListener\WAF\Exceptions\BlockedIpException');

		$storage = m::mock('Ionut\SecurityListener\WAF\StorageInterface');
		$storage->shouldReceive('exists')->once()->andReturn(true);

		$waf = new Manager($storage);
		$waf->setIp('127.0.0.1');
		$waf->listen();
	}

	public function testNonBlockedIp()
	{
		$storage = m::mock('Ionut\SecurityListener\WAF\StorageInterface');
		$storage->shouldReceive('exists')->once()->andReturn(false);

		$waf = new Manager($storage);
		$waf->setIp('127.0.0.1');
		$waf->listen();
	}

	public function testWithoutIp()
	{
		$this->setExpectedException('Ionut\SecurityListener\WAF\Exceptions\WithoutIpException');

		$storage = m::mock('Ionut\SecurityListener\WAF\StorageInterface');

		$waf = new Manager($storage);
		$waf->listen();
	}
}
 