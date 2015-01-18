<?php

use Ionut\Sylar\WAF\Manager;
use Mockery as m;

class ManagerTest extends PHPUnit_Framework_TestCase {

	public function testBlockedIp()
	{
		$this->setExpectedException('Ionut\Sylar\WAF\Exceptions\BlockedIpException');

		$storage = m::mock('Ionut\Sylar\WAF\StorageInterface');
		$storage->shouldReceive('exists')->once()->andReturn(true);

		$waf = new Manager($storage);
		$waf->setIp('127.0.0.1');
		$waf->listen();
	}

	public function testNonBlockedIp()
	{
		$storage = m::mock('Ionut\Sylar\WAF\StorageInterface');
		$storage->shouldReceive('exists')->once()->andReturn(false);

		$waf = new Manager($storage);
		$waf->setIp('127.0.0.1');
		$waf->listen();
	}

	public function testWithoutIp()
	{
		$this->setExpectedException('Ionut\Sylar\WAF\Exceptions\WithoutIpException');

		$storage = m::mock('Ionut\Sylar\WAF\StorageInterface');

		$waf = new Manager($storage);
		$waf->listen();
	}
}
 