<?php
namespace AuthSystem;

interface UserManipulationInterface{
	function addUser(User $user);
	function getUserByLoginAndPassword(string $login, string $passsword);
	function deleteUser(int $id);
}

?>
