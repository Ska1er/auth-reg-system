<?php
namespace AuthSystem;
use Exception;

class DbException extends Exception {
	private string $dbms;

	public function __construct(string $message, string $dbms, $code=0, Throwable $previous = null){
		$this->dbms = $dbms;
		
		parent::__construct($message, $code, $previous);
	}

	public function getDbms(){
		return $this->dbms;
	}


	public function __toString(){
		return __CLASS__ . "({$this->dbms} : {$this->messages})";
	}
}

class DbOperationException extends DbException {
	private string $operation;
	public function __construct(string $message, string $dbms, string $operation){
		$this->operation = $operation;

		parent::__construct($message, $dbms);
	}

	public function getOperation(){
		return $this->operation;
	}
}

class DbConnectionException extends DbException {
	private string $host, $login, $dbName;
	public function __construct(string $message, string $dbms, string $host, string $login, string $dbName) {
		$this->host = $host;
		$this->login = $login;
		$this->dbName = $dbName;
		parent::__construct($message, $dbms);
	}

	public function getHost() {
		return $this->host;
	}

	public function getLogin() {
		return $this->login;
	}

	public function getDb() {
		return $this->dbName;
	}
}
?>
