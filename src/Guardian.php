<?php namespace Ionut\Sylar;

class Guardian {

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

	public $receiveNotify = ['Ionut\Sylar\Receivers\Mail', 'Ionut\Sylar\Receivers\Log', 'Ionut\Sylar\Receivers\Blocker'];
	public $receivers;
	public $enviroment;
	public $config = [];

	/**
	 * @var Filters\BaseCollection
	 */
	protected $collection;

	/**
	 * @param Request $requestReplace
	 */
	public function __construct($requestReplace = null)
	{
		require __DIR__.'/Support/helpers.php';

		$this->setConfigFile('config.php');

		$this->enviroment = new Environment();
		if($requestReplace){
			$this->enviroment->request = $requestReplace;
		}

		$this->receivers = new Receivers($this);
		$this->receivers->bindReceivers($this->receiveNotify);

		$this->wafStorage = new WAF\Storage();
		$this->waf        = new WAF\Manager($this->wafStorage);

		$this->collection = new $this->config['filtersCollection'];
	}

	/**
	 * Listen for security tests by users.
	 *
	 * @return void
	 */
	public function listen()
	{
		if ($this->config['receivers']['blocker']) {
			$this->waf->listen();
		}

		$alerts = $this->examineTheRequest();

		$alerts->each(function($alert){
			$this->receivers->send($alert);
		});

		if($alerts->count()){
			$this->enviroment->events->fire('attacked', [$alerts]);
		}
	}



	/**
	 * Exec all filters from collection for given params.
	 *
	 * @param  array $params
	 *
	 * @return AlertsBag Alerts with matched intrusions.
	 */
	public function examineTheRequest(array $params = null)
	{
		$params = $params ?: $this->request->getDataForTesting();

		$alerts = new AlertsBag;
		foreach ($params as $k => $v) {
			if (is_array($v)) {
				if (empty($v)) {
					continue;
				}
				$alerts = $alerts->merge($this->examineTheRequest($v));
			} else {
				$f = function($filter) use($k, $v, $alerts){
					/* @var $filter Filters\FilterAbstract **/
					if($filter->match($v)){
						$alerts->push($alert = new Alert($filter, $k, $v));
					}
				};
				$this->collection->each($f);
			}
		}

		return $alerts;
	}


	/**
	 * @param string $v Value for testing.
	 *
	 * @return array
	 */
	public function checkAlertType($v)
	{
		foreach($this->collection->all() as $filter){
			/* @var $filter Filters\FilterAbstract **/
			if($filter->match($v)){
				return $filter->toArray();
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
		return $this->config = config_merge($this->config, $config);
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

	public function when($k, $closure)
	{
		return $this->enviroment->events->listen($k, $closure);
	}

	public function __get($k)
	{
		return $this->enviroment[$k];
	}
}