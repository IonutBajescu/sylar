<?php namespace Ionut\SecurityListener\WAF;

class Manager {

	protected $ip;

	/**
	 * @var Storage
	 */
	private $storage;

	public function __construct(StorageInterface $storage)
	{
		$this->storage = $storage;

		if (isset($_SERVER['REMOTE_ADDR'])) {
			$this->setIp($_SERVER['REMOTE_ADDR']);
		}
	}

	public function listen()
	{
		$ip = $this->getIp();
		if(is_null($ip)){
			throw new Exceptions\WithoutIpException();
		}

		if ($this->storage->exists($ip)) {
			throw new Exceptions\BlockedIpException();
		}
	}

	public function getIp()
	{
		return $this->ip;
	}

	public function setIp($ip){
		$this->ip = $ip;
	}
} 