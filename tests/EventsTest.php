<?php

use Ionut\Sylar\Guardian;
use Mockery\Exception;

class EventsTest extends PHPUnit_Framework_TestCase {

	public function testBasicAttackerEvent()
	{
		$this->setExpectedException('ThisTestItsOkay');

		$guardian = new Guardian();
		$guardian->request->setInput(['test' => 'nana\'']);
		$guardian->when('attacked', function($alerts) {
			throw new ThisTestItsOkay();
		});
		$guardian->listen();
	}
}

class ThisTestItsOkay extends Exception {

}