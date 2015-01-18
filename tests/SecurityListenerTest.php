<?php

use Ionut\Sylar\Listener as SecurityListener;
use Ionut\Sylar\Request;


class SecurityListenerTest extends PHPUnit_Framework_TestCase {

	public function testBasicSqliRequestTesting()
	{
		$input = ['id' => "50'"];;
		$request = $this->mockInput($input);

		$listener = new SecurityListener($request);
		$errors = $listener->sendInputToFilters();
		$this->assertCount(2, $errors);
	}

	public function testPatternsForSqli()
	{
		$inputParams = [
							"Hello'"             => 'sqli',
							'I\'m Ionut'         => false,
							'What is your name?' => false,
							'-1 order by 6-- -'  => 'sqli'
						];

		$SL = new SecurityListener($this->mockInput());
		foreach($inputParams as $bypasss => $expected){
			$result = $SL->checkAlertType($bypasss);
			$this->assertEquals($expected, $result[1]);
		}
	}

	public function testPatternsBypassesForSqli()
	{
		// all must trigger security listener
		$wafBypasses = [
							'-725+/*!UNION*/+/*!SELECT*/+1,2,3,4,5-',
							'-725+/*!UNION*/+/*!SELECT*/+1,CONCAT(database(),user(),version()),3,4,5--',
							'-725+/*!UNION*/+/*!SELECT*/+1,ConCAt(database(),user(),version()),3,4,5-- ',
							'-725+/*!UNION*/+/*!SELECT*/+1,GROUP_CONCAT(SCHEMA_NAME),3,4,5+FROM+INFORMATION_SCHEMA.SCHEMATA--',
							'-725+/*!UNION*/+/*!SELECT*/+1,GrOUp_COnCaT(SCHEMA_NAME),3,4,5+FROM+INFORMATION_SCHEM.SCHEMATA--',
							'-725+/*!UNION*/+/*!SELECT*/+1,GrOUp_COnCaT(id,0x3a,login,0x3a,password,0x3a,email,0x3a),3,4,5+FROM+Admin—',
							'-725+/*!UNION*/+/*!SELECT*/+1,GrOUp_COnCaT(COLUMN_NAME),3,4,5+FROM+/*!INFORMATION_SCHEM*/.COLUMNS+WHERE+TABLE_NAME=0x41646d696e--',
							'/*!UnIOn*//*!SeLect*/+1,2,3—',
							'/**//*U*//*n*//*I*//*o*//*N*//*S*//*e*//*L*//*e*//*c*//*T*/1,2,3—',
							'un/**/ion+sel/**/ect+1,2,3—'
						];

		$SL = new SecurityListener($this->mockInput());
		foreach($wafBypasses as $bypasss){
			$result = $SL->checkAlertType($bypasss);
			$this->assertEquals('sqli', $result[1], "Test bypass {$bypasss} for sqli.");
		}
	}

	public function testPatternsForXss()
	{
		$inputParams = [
			'"><script>alert(1337);</script>'                       => 'xss',
			'"><script src="http://hacker.com/script.js"></script>' => 'xss',
			'I know javascript'                                     => false,
			'Lorem ipsum'                                           => false
		];
		$SL = new SecurityListener($this->mockInput());
		foreach($inputParams as $param => $expected){
			$result = $SL->checkAlertType($param);
			$this->assertEquals($expected, $result[1]);
		}
	}

	public function testPatternsForLfi()
	{
		$inputParams = [
			'../../../../../../etc/passwd' => 'lfi',
			'Lorem ipsum'                  => false
		];
		$SL = new SecurityListener($this->mockInput());
		foreach($inputParams as $param => $expected){
			$result = $SL->checkAlertType($param);
			$this->assertEquals($expected, $result[1]);
		}
	}

	public function mockInput(array $input = array())
	{
		$mock = $this->getMock('Ionut\\SecurityListener\\Request');
	    $mock->expects($this->any())->method('getDataForTesting')->will($this->returnValue($input));
		return $mock;
	}
}
