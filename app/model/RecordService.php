<?php


class RecordService extends Nette\Object
{
	/** @var Nette\Database\Connection */
	private $database;

	/** @var string */
	private $ip;



	public function __construct(Nette\Database\Connection $database, $ip = null)
	{
		$this->database = $database;
		$this->ip = $ip ?: @$_SERVER['REMOTE_ADDR'];
	}



	public function add($message, $content)
	{
		return $this->database->table('records')->insert(array(
			'message' => $message,
			'content' => $content,
			'added' => new DateTime,
			'ip' => $this->ip,
		));
	}


	public function fetch($id)
	{
		return $this->database->table('records')->get($id);
	}

}