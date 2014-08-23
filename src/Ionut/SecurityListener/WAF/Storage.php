<?php namespace Ionut\SecurityListener\WAF;


class Storage implements StorageInterface {

	protected $rows = [];
	protected $original = [];
	protected $file = './storage.json';


	public function __construct()
	{
		$contents = json_decode(file_get_contents($this->file));
		var_dump($contents);
	}

	public function __destruct()
	{
		$this->saveChanges();
	}

	protected function saveChanges()
	{
		if($this->rows != $this->original){
			file_put_contents($this->file, json_encode($this->rows));
		}
	}

	public function exists($row)
	{
		return array_search($row, $this->rows);
	}

	public function add($row)
	{
		$this->rows[] = $row;
	}

	public function remove($row)
	{
		foreach($this->rows as $k => $row){
			if($row == $row){
				unset($this->rows[$k]);
			}
		}
	}
} 