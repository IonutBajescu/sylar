<?php namespace Ionut\SecurityListener;

/**
 * SecurityListener - Listen for security tests made on your site.
 */
class Listener {


	/**
	 * @return void
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;

		$this->config = (object)(include 'config.php');
	}

	/**
	 * Create a factory of class without bind manually dependencies.
	 *
	 * @return \\Ionut\\SecurityListener\\Listener
	 */
	static function factory()
	{
		$request = new Request;
		return new self($request);
	}

	/**
	 * Listen for security tests by users.
	 *
	 * @return void
	 */
	public function listen()
	{
		$errors = $this->parseMatches();

		foreach($errors as $summary){
			if($this->config->on_trigger['log_event']){
				$this->logEvent($summary);
			}

			if($this->config->on_trigger['send_to_email']){
				$this->sendToEmail($summary);
			}

			if($this->config->on_trigger['block_ip']){
				$this->blockIp();
			}
		}
	}

	/**
	 * Log event to a file.
	 *
	 * @param  string $summary Event summary.
	 * @return void
	 */
	public function logEvent($summary)
	{
		$file = $this->config->on_trigger['log_event']['to'];
		file_put_contents($file, $summary.PHP_EOL, FILE_APPEND);
	}

	public function blockIp()
	{
		throw new Exception('Not implemented');
	}

	public function sendToEmail($summary)
	{
		throw new Exception('Not implemented');
	}

	/**
	 * Parse all matchers from config on given parameters.
	 *
	 * @param  array $params
	 * @return array Matched vulnerability tests
	 */
	public function parseMatches(array $params = null)
	{
		$params = $params ?: $this->request->getDataForTesting();

		$errors = [];
		foreach($params as $k => $v){
			if(is_array($v)){
				$errors = array_merge($errors, $this->parseMatches($v));
			} else{
				list($pattern,$type) = $this->testConfigPatterns($v);
				if($type){
					// security test finded in request
					$errors[] = $this->securityExceptionSummary($pattern, $k, $type);
				}
			}
		}

		return $errors;
	}

	/**
	 * Make a readable summary of attack.
	 *
	 * @param  array  $pattern
	 * @param  string $paramName
	 * @param  string $attackType
	 * @return string Summary of attack.
	 */
	public function securityExceptionSummary($pattern, $paramName, $attackType)
	{
		$patternDesc = $this->formatPatternDesc($pattern, $paramName);

		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

		$attackType = strtoupper($attackType);
		$date = date('d.m.Y H:i');
		return "$date [$attackType] {$ip} on $paramName - $patternDesc";
	}

	/**
	 * Format description of a pattern from config.
	 *
	 * @param  array  $pattern
	 * @param  string $paramName
	 * @return string
	 */
	public function formatPatternDesc($pattern, $paramName)
	{
		return str_replace('{param}', $paramName, $pattern['desc']);
	}

	/**
	 * Test config patterns for a specified value.
	 *
	 * @param  string $v
	 * @return array
	 */
	public function testConfigPatterns($v)
	{
		foreach($this->config->patterns as $type => $patternsByType){
			foreach($patternsByType as $pattern){
				if(preg_match($pattern['pattern'], $v)){
					return [$pattern, $type];
				}
			}
		}

		return [false,false];
	}
}