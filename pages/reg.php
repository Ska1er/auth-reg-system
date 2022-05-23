<?php
namespace AuthSystem;
require_once('../helpers/MySqlHelper.php');
require_once('../models/User.php');
require_once('../helpers/SessionHelper.php');
require_once('../helpers/RelocationHelper.php');

$errors = array();

function getStringCharacters(array $characters) {
	$stringCharacters = "";
	foreach($characters as $character){
		$stringCharacters .=$character." ";
	}
	return $stringCharacters;
}


if(!empty($_SESSION['currentUser'])){
	relocate('http://localhost/php-projects/auth-system/pages/profile.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	if(empty($_POST['name'])) {
		$errors['name'] ='Name not specified'; 
	}
	if(empty($_POST['surname'])) {
		$errors['surname'] ='Surname not specified'; 
	}
	if(empty($_POST['patronymic'])) {
		$errors['patronymic'] ='Patronymic not specified'; 
	}
	if(empty($_POST['gender'])) {
		$errors['gender'] ='Gender not specified'; 
	}
	if(empty($_POST['speciality'])) {
		$errors['speciality'] ='Speciality not specified'; 
	}
	if(empty($_POST['characters'])) {
		$errors['characters'] ='Characters not specified'; 
	}
	if(empty($_POST['login'])) {
		$errors['login'] ='Login not specified'; 
	}
	if(empty($_POST['password'])) {
		$errors['password'] ='Password not specified'; 
	}

	if(!$errors){
		$user = new User(htmlentities($_POST['name']), htmlentities($_POST['surname']), htmlentities($_POST['patronymic']),
			htmlentities($_POST['login']), htmlentities($_POST['password']), $_POST['gender'],
		   	$_POST['speciality'], getStringCharacters($_POST['characters']));

		$db = new MySqlHelper();
		if($db->addUser($user))
			relocate("http://localhost/php-projects/auth-system/pages/login.php");
		else $errors['common'] = "Registration error";
	}
}

?>

<!doctype html>
<html>
	<head>
		<title>auth system</title>
		<meta charset='utf-8'>
		<meta name="viewport" content="width=device-width,initial_scale=1">
		<link href="../styles/main.css" rel="stylesheet"/>
		<link href="../styles/custom-text.css" rel="stylesheet"/>
		<link href="../styles/custom-checkbox.css" rel="stylesheet"/>
		<link href="../styles/custom-radio.css" rel="stylesheet"/>
		<link href="../styles/custom-select.css" rel="stylesheet"/>
		<link href="../styles/buttons.css" rel="stylesheet"/>
		<link href="../styles/error.css" rel="stylesheet"/>
	</head>
	<body>
		<div class="reg-block block">
			<h2 class="reg-block__title title">Registration form</h2>
			<div class="reg-block__reg-form-block form-block">
				<form class="reg-block__reg-from" action="" method="post">
					<div class="reg-block__input-text-block input-text-block">
						<input class="reg-block__input-text-name input-text" value="<?php if(isset($_POST['name'])) echo(htmlentities($_POST['name'])); else echo("")?>" placeholder="" name="name" type="text"/>
						<label class="reg-block__text-label text-label">Name</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['name'])) echo $errors['name'];?>	
							</p>
						</div>
					</div>
					<div class="reg-block__input-text-block input-text-block">
						<input class="reg-block__input-text-surname input-text" value="<?php if(isset($_POST['surname'])) echo(htmlentities($_POST['surname'])); else echo("")?>" placeholder="" name="surname" type="text"/>
						<label class="reg-block__text-label text-label">Surname</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['surname'])) echo $errors['surname']?>	
						</p>
						</div>
					</div>
					<div class="reg-block__input-text-block input-text-block">
						<input class="reg-block__input-text-patronymic input-text" value="<?php if(isset($_POST['patronymic'])) echo(htmlentities($_POST['patronymic'])); else echo("")?>" placeholder="" name="patronymic" type="text"/>
						<label class="reg-block__text-label text-label">Patronymic</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['patronymic'])) echo $errors['patronymic']?>
							</p>
						</div>
					</div>
					<div class="reg-block__gender-block">
						<div class="reg-block__gender-block-title">
							<p class="reg-block__title-radio">Choose gender:</p>
						</div>
						<div class="reg-block__gender-block-flex">
							<div class="reg-block__gender-block">
							<input class="reg-block__input-radio-item input-custom-radio" id="man" <?php if(!isset($errors['gender']) && isset($_POST['gender']) && $_POST['gender'] == 'm') echo 'checked';?>  name="gender" value="m" type="radio"/>
								<label class="reg-block__radio-label" for="man">Man</label>
							</div>
							<div class="reg-block__gender-block">
								<input class="reg-block__input-radio-item input-custom-radio" id="woman" <?php if(!isset($errors['gender']) && isset($_POST['gender']) && $_POST['gender'] == 'w') echo 'checked';?> name="gender" value="w" type="radio"/>
								<label class="reg-block__radio-label" for="woman">Woman</label>
							</div>
						</div>
						<div class="gender-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['gender'])) echo $errors['gender']?>
							</p>
						</div>
					</div>
					<div class="reg-block__input-checkbox-characters-block">
						<div class="reg-block__input-checkbox-characters-block-title">
							<p class="reg-block__title-checkbox">Choose character/characters</p>
						</div>
						<div class="reg-block__input-checkbox_block">
							<input class="reg-block__input-chekbox-item input-custom-checkbox" value="honest" id="honest" <?php if(!isset($errors['characters']) && isset($_POST['characters']) && in_array("honest",$_POST['characters'])) echo 'checked';?> name="characters[]" type="checkbox"/>
							<label class="reg-block__checkbox-label" for="honest">Honest</label>
						</div>
						<div class="reg-block__input-checkbox_block">
							<input class="reg-block__input-chekbox-item input-custom-checkbox" value="hardy" id="hardy" <?php if(!isset($errors['characters']) && isset($_POST['characters']) && in_array("hardy",$_POST['characters'])) echo 'checked';?> name="characters[]" type="checkbox"/>
							<label class="reg-block__checkbox-label" for="hardy">Hardy</label>
						</div>
						<div class="reg-block__input-checkbox_block">
							<input class="reg-block__input-chekbox-item input-custom-checkbox" value="tough" id="tough" <?php if(!isset($errors['characters']) && isset($_POST['characters']) && in_array("tough",$_POST['characters'])) echo 'checked';?> name="characters[]" type="checkbox"/>
							<label class="reg-block__checkbox-label" for="tough">Tough</label>
						</div>
						<div class="reg-block__input-checkbox_block">
							<input class="reg-block__input-chekbox-item input-custom-checkbox" value="sly" id="sly" <?php if(!isset($errors['characters']) && isset($_POST['characters']) && in_array("sly",$_POST['characters'])) echo 'checked';?> name="characters[]" type="checkbox"/>
							<label class="reg-block__checkbox-label" for="sly">Sly</label>
						</div>
						<div class="input-checkbox-characters-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['characters'])) echo $errors['characters']?>
							</p>
						</div>
					</div>
					<div class="reg-block__select-speciality-block"> 
						<div class="reg-block__select-speciality-block-title">
							<p class="reg-block__select-speciality-title">Choose speciality</p>
						</div>
						<details class="reg-block__details-select custom-select">
							<summary class="reg-block__custom-select-items radios">
								<input type="radio" name="speciality"  id="item1" value="Frontend" <?php if(!isset($errors['speciality']) == "" && isset($_POST['speciality']) && $_POST['speciality'] == "Frontend") echo 'checked';?> title="Frontend">
								<input type="radio" name="speciality" id="item2" value="Backend" <?php if(!isset($errors['speciality']) == "" && isset($_POST['speciality']) && $_POST['speciality'] == "Backend") echo 'checked';?> title="Backend">
								<input type="radio" name="speciality" id="item3" value="Fullstack" <?php if(!isset($errors['speciality']) == "" && isset($_POST['speciality']) && $_POST['speciality'] == "Fullstack") echo 'checked';?> title="Fullstack">
							</summary>
							<ul class="select-list">
								<li>
									<label for="item1">Frontend</label>
								</li>
								<li>
									<label for="item2">Backend</label>
								</li>
								<li>
									<label for="item3">Fullstack</label>
								</li>
							</ul>
						</details>
						<div class="select-speciality-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['speciality'])) echo $errors['speciality']?>
							</p>
						</div>
					</div>
					<div class="reg-block__input-text-block input-text-block">
						<input class="reg-block__input-text-login input-text" value="<?php if(isset($_POST['login'])) echo(htmlentities($_POST['login'])); else echo("")?>" placeholder="" name="login" type="text"/>		
						<label class="reg-block__text-label text-label">Login</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['login'])) echo $errors['login']?>
							</p>
						</div>
					</div>
					<div class="reg-block__input-text-block input-text-block">
						<input class="reg-block__input-text-password input-text" vvalue="<?php if(isset($_POST['password'])) echo(htmlentities($_POST['password'])); else echo("")?>" placeholder="" name="password" type="password"/>
						<label class="reg-block__text-label text-label">Password</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['password'])) echo $errors['password']?>
							</p>
						</div>
					</div>
					<div class="reg-block__buttons-block">
						<div class="buttons-block__submit-button">
							<input type="submit" value="Sign up"/>
						</div>
						<div class="buttons-block__back-button">
							<a draggable="false" href="login.php">Back</a>
						</div>
					</div>
					<div class="reg-block__error-block error-block">
						<p class="error-block__error-message">
							<?php if(isset($errors['common'])) echo $errors['common']?>
						</p>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>


