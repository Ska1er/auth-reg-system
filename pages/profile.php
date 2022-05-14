<?php

namespace AuthSystem;
require_once('../models/User.php');
require_once('../helpers/SessionHelper.php');
require_once('../helpers/RelocationHelper.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	unset($_SESSION['currentUser']);
}

if(empty($_SESSION['currentUser'])) {
	relocate('http://localhost/php-projects/auth-system/pages/login.php');
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Profile</title>
		<meta charset="utf-8">
		<link href="../styles/buttons.css" rel="stylesheet"/>
		<link href="../styles/main.css" rel="stylesheet"/>
	</head>
	<body>
		<div class="profile-block block">
			<div class="profile-block__title">
				<h1 class="title">Profile page</h1>
			</div>
			<div class="profile-block__main-info">
				<div class="main-info__initials">
					<p><?="{$_SESSION['currentUser']->getSurname()} {$_SESSION['currentUser']->getName()} {$_SESSION['currentUser']->getPatronymic()}"?><p>
				</div>
				<div class="main-info__skills">
					<div class="skills__speciality">
						<p><b>Speciality: </b><?=$_SESSION['currentUser']->getSpeciality()?></p>
					</div>
					<div class="skills__characters">
						<p><b>Characters: </b><?=$_SESSION['currentUser']->getCharacters()?></p>
					</div>
				</div>
			</div>
			<div class="profile-block__logout-form-block">
				<form class="logout-form-block__form-block form-block" action="#" method="POST">
					<div class="buttons-block__submit-button">
						<input type="submit" value="Logout"/>
					</div>
				</form>	
			</div>
		</div>
	</body>
</html>
