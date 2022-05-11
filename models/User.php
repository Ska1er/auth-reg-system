<?php
namespace AuthSystem;

class User {
	private int $id;
	private string $name, $surname, $patronymic;
	private string $login, $password;
	private string $sex, $speciality, $characters; 

	function __construct($name, $surname, $patronymic, $login, $password, $sex, $speciality, $characters, $id=-1){
		$this->name = $name;
		$this->surname =$surname;
		$this->patronymic = $patronymic;
		$this->login = $login;
		$this->password = $password;
		$this->sex = $sex;
		$this->speciality = $speciality;
		$this->characters= $characters;
		$this->id = $id;
	}

	public function getName(){
		return $this->name;
	}
	
	public function getSurname(){
		return $this->surname;
	}

	public function getPatronymic(){
		return $this->patronymic;
	}

	public function getLogin(){
		return $this->login;
	}

	public function getPassword(){
		return $this->password;
	}

	public function getSex(){
		return $this->sex;
	}
	
	public function getCharacters(){
		return $this->characters;
	}

	public function getSpeciality(){
		return $this->speciality;
	}

	public function getId(){
		return $this->id;
	}
}


