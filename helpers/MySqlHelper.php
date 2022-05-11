<?php
namespace AuthSystem;

require_once('../interfaces/UserManipulationInterface.php');
require_once('../models/User.php');
require_once('../customExceptions/DbException.php');

class MySqlHelper implements UserManipulationInterface{
	const DBMS = "mysql";
	private string $host, $login, $password, $dbName;	
	private $db;
	function __construct(string $host="localhost", string $login="root", string $password="root", string $dbName="auth_system") {
		$this->host = $host;
		$this->login = $login;
		$this->password = $password;
		$this->dbName = $dbName;

		try {
			$this->db = $this->connect();
		}
		catch(DbConnectionException $ex){
			throw $ex;
		}
	}

	private function connect(){
		$connection = mysqli_connect($this->host, $this->login, $this->password, $this->dbName);
		if(mysqli_connect_errno())
			throw new DbConnectionException(mysqli_connect_error(), self::DBMS, $this->host, $this->login, $this->dbName);
		return $connection;
	}

	public function addUser(User $user){
		$sql = "insert into user values(
				'{$user->getName()}',
				'{$user->getSurname()}',
				'{$user->getPatronymic()}',
				'{$user->getSex()}',
				'{$user->getCharacters()}',
				'{$user->getSpeciality()}',
				'{$user->getLogin()}',
				'{$user->getPassword()}',
			   	null)";
		$result = mysqli_query($this->db, $sql);
		if(!$result)
			throw new DbOperationException(mysqli_error($this->db), self::DBMS, "create");
	}

	public function getUserByLoginAndPassword(string $login, string $password){
		$sql = "Select * from user where login = '{$login}' and password='{$password}'";
		$result = mysqli_query($this->db, $sql);
		if(mysqli_num_rows($result) == 0){
			return null;
		}
		$rows = mysqli_fetch_array($result);
		$user = new User($rows['name'], $rows['surname'], $rows['patronymic'], $rows['login'], $rows['password'], $rows['sex'], $rows['speciality'], $rows['characters']);
		return $user;
	}

	public function deleteUser(int $id){
		$sql = "Delete from user where id = {$id}";
		$result = mysqli_query($this->db, $sql);
		if($result)
			throw new DbOperationException(mysqli_error($this->db),DBMS,"delete");
	}

	function __destruct(){
		mysqli_close($this->db);
	}
}	
?>
