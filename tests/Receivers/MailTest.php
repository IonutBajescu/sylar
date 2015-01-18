<?php

use Ionut\Sylar\Listener as SecurityListener;
use Ionut\Sylar\Request;
use Ionut\Sylar\DynamicObject;
use Mockery as m;

class MailTest extends PHPUnit_Framework_TestCase {

	public function testIfListenerFireMailer()
	{
		$config = include __DIR__.'/../../src/config.php';
		// turn on mailer
		$config['receivers']['mail'] = 
			[
				'to' => 'test@example.com',
				'from' => 'test@example.com',
				'subject' => 'Hello'
			];

		$listener = new SecurityListener($this->mockInput(['sql' => "1337'"]));
		$listener->config = (object)$config;

		$mailerFired = false;
		$listener->container->bind('Swift_MailTransport', function() use(&$mailerFired){
			$mocked = new DynamicObject;
			$mocked->send = function() use(&$mailerFired){
				$mailerFired = true;
			};
			return $mocked;
		});
		$listener->listen();

		$this->assertEquals($mailerFired, true);
	}

	public function mockInput(array $input = array())
	{
		$mock = $this->getMock('Ionut\\Sylar\\Request');
	    $mock->expects($this->any())->method('getDataForTesting')->will($this->returnValue($input));
		return $mock;
	}

}
