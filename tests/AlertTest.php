<?php

/**
 * This class don't test anything. But it shows debug information.
 */
class AlertTest extends PHPUnit_Framework_TestCase {

	/**
	 * @group debug
	 * @dataProvider alertContructor
	 */
	public function testGenerateSummary()
	{
		$this->markTestSkipped(
			__CLASS__.' is only for debug info.'
		);

		$alert = call_user_func_array(
					array(new ReflectionClass('Ionut\SecurityListener\Alert'), 'newInstance'),
					func_get_args()
				);

		echo $alert->getInfo();
		echo PHP_EOL;
		echo $alert->getHtmlInfo();
	}

	public function alertContructor(){
		return [
			['sqli', ['desc' => 'Attack description', 'gravity' => 'high'], 'id', "12'"]
		];
	}
}
 