<?php namespace Ionut\Sylar;

class Request {
	protected $input;

	function __construct()
	{
		$this->input = [$_REQUEST, ['REQUEST_URI' => 0, 'QUERY_STRING' => 0] + $_SERVER];
	}

	/**
	 * Get all request parameters for tests.
	 *
	 * Some dangerous data may exists in $_SERVER.
	 * That's why we use $_REQUEST and $_SERVER.
	 * Example of data: user agent, user "real" ip.
	 *
	 * @return array
	 */
	public function getDataForTesting()
	{
		return $this->input;
	}

	/**
	 * @return array
	 */
	public function getInput()
	{
		return $this->input;
	}

	/**
	 * @param array $input
	 */
	public function setInput($input)
	{
		$this->input = $input;
	}
}

