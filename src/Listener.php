<?php namespace Ionut\Sylar;


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

	public $receiveNotify = ['Ionut\Sylar\Receivers\Mail', 'Ionut\Sylar\Receivers\Log', 'Ionut\Sylar\Receivers\Blocker'];
	public $receivers;
	public $container;
	public $config;
	public $request;

	/**
	 * @var Filters\CollectionInterface
	 */
	protected $collection;

	/**
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{

		$this->config    = $this->setConfigFile('config.php');

		$this->request   = $request;

		$this->container = new Container;

		$this->receivers = new Receivers($this);
		$this->receivers->bindReceivers($this->receiveNotify);

		$this->wafStorage = new WAF\Storage();
		$this->waf        = new WAF\Manager($this->wafStorage);

		$this->collection = new $this->config->filtersCollection;
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

		$errors = $this->sendInputToFilters();

		foreach ($errors as $summary) {
			$this->receivers->send($summary);
		}
	}



	/**
	 * Exec all filters from collection for given params.
	 *
	 * @param  array $params
	 *
	 * @return array Alerts with matched intrusions.
	 */
	public function sendInputToFilters(array $params = null)
	{
		$params = $params ?: $this->request->getDataForTesting();

		$errors = [];
		foreach ($params as $k => $v) {
			if (is_array($v)) {
				if (empty($v)) {
					continue;
				}
				$errors = array_merge($errors, $this->sendInputToFilters($v));
			} else {
				// check all filters
				foreach($this->collection->all() as $filter){
					/* @var $filter Filters\FilterAbstract **/
					if($filter->match($v)){
						$errors[] = new Alert($filter, $k, $v);
					}
				}
			}
		}

		return $errors;
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