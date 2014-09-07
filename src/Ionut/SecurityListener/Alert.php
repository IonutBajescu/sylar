<?php namespace Ionut\SecurityListener;

class Alert {

	public $gravityRange = [
		'low',
		'medium',
		'high'
	];

	private $type;
	private $gravity;
	private $requestKey;
	private $requestValue;
	private $pattern;

	function __construct($type, $pattern, $requestKey, $requestValue)
	{
		$this->type         = $type;
		$this->requestKey   = $requestKey;
		$this->requestValue = $requestValue;
		$this->pattern      = $pattern;

		$this->gravity = $pattern['gravity'];
	}

	/**
	 * @param string $gravity
	 *
	 * @return bool
	 */
	public function isWorstThan($gravity)
	{
		return $this->getGravityIndex() >= array_search($gravity, $this->gravityRange);
	}

	public function getGravityIndex()
	{
		return array_search($this->gravity, $this->gravityRange);
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	public function __toString()
	{
		return $this->getInfo();
	}

	/**
	 * Make a readable summary of attack.
	 *
	 * @return string Summary of attack.
	 */
	public function getInfo()
	{
		list($patternDesc, $ip, $type, $date) = $this->infoParameters();

		return "$date [$type] {$ip} on $this->requestKey with $this->requestValue - $patternDesc";
	}

	public function getHtmlInfo(){
		list($patternDesc, $ip, $type, $date) = $this->infoParameters();

		$ipLink = '<a href="http://whois.domaintools.com/'.$ip.'">'.$ip.'</a>';
		return "$date [$type] {$ipLink} on <b>$this->requestKey</b> with <b>$this->requestValue</b> - <i>$patternDesc</i>";
	}

	/**
	 * @return array
	 */
	protected function infoParameters()
	{
		$patternDesc = str_replace('{param}', $this->requestKey, $this->pattern['desc']);

		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;

		$type = strtoupper($this->type);
		$date = date('d.m.Y H:i');

		return array($patternDesc, $ip, $type, $date);
	}


}