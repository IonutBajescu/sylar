<?php namespace Ionut\SecurityListener;

class Request {

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
		return [$_REQUEST, ['REQUEST_URI'=>0,'QUERY_STRING'=>0]+$_SERVER];
	}
}

