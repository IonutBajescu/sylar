<?php namespace Ionut\Sylar\WAF;


class Storage implements StorageInterface {

	protected $rows = null;
	protected $original = null;
	protected $file;


	public function __construct()
	{
		$this->file = dirname(dirname(dirname(dirname(__DIR__)))) . '/data/waf.json';
	}

	public function __destruct()
	{
		$this->saveChanges();
	}

	protected function saveChanges()
	{
		if ($this->rows != $this->original) {
			file_put_contents($this->file, json_encode($this->rows));
		}
	}

	public function exists($row)
	{
		if (is_null($this->original)) {
			$this->initializeData();
		}

		return array_search($row, $this->rows) !== false;
	}

	public function initializeData()
	{
		if(!file_exists($this->file)){
			$this->clear(); // new file
		}

		$contents       = file_get_contents($this->file);
		$this->original = $this->rows = json_decode($contents);
	}

	public function add($row)
	{
		$this->rows[] = $row;
		$this->rows   = array_unique($this->rows);
	}

	public function remove($row)
	{
		foreach ($this->rows as $k => $row) {
			if ($row == $row) {
				unset($this->rows[$k]);
			}
		}
	}

	public function clear()
	{
		file_put_contents($this->file, '[]');
	}

} 