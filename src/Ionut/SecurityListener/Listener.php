<?php namespace Ionut\SecurityListener;


/**
 * SecurityListener - Listen for security tests made on your site.
 */
class Listener {

	public $types = [
		'low',
		'medium',
		'high'
	];
	/**
	 * @var WAF\Storage
	 */
	public $wafStorage;
	/**
	 * @var WAF\Manager
	 */
	public $waf;

	public $receiveNotify = ['Ionut\SecurityListener\Receivers\Mail', 'Ionut\SecurityListener\Receivers\Log', 'Ionut\SecurityListener\Receivers\Blocker'];
	public $receivers;
	public $container;
	public $config;
	public $request;

	/**
	 * @return void
	 */
	public function __construct(Request $request)
	{

		$this->config = $this->setConfigFile('config.php');

		$this->request = $request;

		$this->container = new Container;

		$this->receivers = new Receivers($this);
		$this->receivers->bindReceivers($this->receiveNotify);

		$this->wafStorage = new WAF\Storage();
		$this->waf        = new WAF\Manager($this->wafStorage);
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
		if ($this->config->receivers['blocker']) {
			$this->waf->listen();
		}

		$errors = $this->parseMatches();

		foreach ($errors as $summary) {
			$this->receivers->send($summary);
		}
	}


	/**
	 * Parse all matchers from config on given parameters.
	 *
	 * @param  array $params
	 *
	 * @return array Matched vulnerability tests
	 */
	public function parseMatches(array $params = null)
	{
		$params = $params ?: $this->request->getDataForTesting();

		$errors = [];
		foreach ($params as $k => $v) {
			if (is_array($v)) {
				if (empty($v)) {
					continue;
				}
				$errors = array_merge($errors, $this->parseMatches($v));
			} else {
				list($pattern, $type) = $this->testConfigPatterns($v);
				if ($type) {
					// security test finded in request
					$errors[] = new Alert($type, $pattern, $k, $v);
				}
			}
		}

		return $errors;
	}

	/**
	 * Test config patterns for a specified value.
	 *
	 * @param  string $v
	 *
	 * @return array
	 */
	public function testConfigPatterns($v)
	{
		foreach ($this->config->patterns as $type => $patternsByType) {
			foreach ($patternsByType as $pattern) {
				if (preg_match($pattern['pattern'], $v)) {
					return [$pattern, $type];
				}
			}
		}

		return [false, false];
	}

	/**
	 * @param array $config
	 *
	 * @return object
	 */
	public function setConfig(array $config)
	{
		return $this->config = (object)$config;
	}


	/**
	 * @param $file
	 *
	 * @return object
	 */
	public function setConfigFile($file)
	{
		return $this->setConfig(require $file);
	}

}