<?php
namespace AuthSystem;

require_once('../interfaces/UserManipulationInterface.php');
require_once('../models/User.php');

class MySqlHelper implements UserManipulationInterface{
	private string $host, $login, $password, $dbName;	
	private $db;
	function __construct(string $host="localhost", string $login="root", string $password="root", string $dbName="auth_system") {
		$this->host = $host;
		$this->login = $login;
		$this->password = $password;
		$this->dbName = $dbName;
		$this->db = $this->connect();
	}

	private function connect(){
		echo class_exists('mysqli');
		$connection = new \mysqli($this->host, $this->login, $this->password, $this->dbName);
		return $connection;
	}

	public function addUser(User $user){
		$sql = "insert into user(name, surname, patronymic, sex, characters, speciality, login, password)
		   		values(?,?,?,?,?,?,?,?)";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param('ssssssss',
				$user->getName(),
				$user->getSurname(),
		   		$user->getPatronymic(),
				$user->getSex(),
				$user->getCharacters(),
				$user->getSpeciality(),
				$user->getLogin(),
				$user->getPassword(),
		);
		$result = $stmt->execute();
		$stmt->close();
		if(!$result)
			return false;
		return true;
	}

	public function getUserByLoginAndPassword(string $login, string $password){
		$sql = "Select * from user where login=? and password=?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param('ss', $login, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if($result->num_rows == 0){
			return null;
		}
		$rows = $result->fetch_assoc();
		$user = new User($rows['name'], $rows['surname'], $rows['patronymic'], $rows['login'], $rows['password'], $rows['sex'], $rows['speciality'], $rows['characters']);
		return $user;
	}

	public function deleteUser(int $id){
		$sql = "Delete from user where id =?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param('i', $id);
		$result = $stmt->execute();
		$stmt->close();
		if($result)
			return false;
		return true;
	}

	function __destruct(){
		$db->close();
	}
}	
?>
