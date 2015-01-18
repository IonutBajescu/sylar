<?php namespace Ionut\Sylar;

use Ionut\Sylar\Filters\FilterAbstract;

class Alert {

	private $requestKey;
	private $requestValue;
	/**
	 * @var FilterAbstract
	 */
	private $filter;


	/**
	 * @param FilterAbstract $filter
	 * @param                $requestKey
	 * @param                $requestValue
	 */
	function __construct(FilterAbstract $filter, $requestKey, $requestValue)
	{
		$this->filter = $filter;
		$this->requestKey   = $requestKey;
		$this->requestValue = $requestValue;

	}

	/**
	 * @param string $gravity
	 *
	 * @return bool
	 */
	public function isWorstThan($gravity)
	{
		return $this->filter->getGravity() >= $gravity;
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
		$patternDesc = str_replace('{param}', $this->requestKey, $this->filter->getDesc());

		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;

		$type = strtoupper($this->filter->getType());
		$date = date('d.m.Y H:i');

		return array($patternDesc, $ip, $type, $date);
	}


}