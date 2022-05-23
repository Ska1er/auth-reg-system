<?php
namespace AuthSystem;
require_once('../helpers/MySqlHelper.php');
require_once('../helpers/SessionHelper.php');
require_once('../helpers/RelocationHelper.php');

$errors = array();

if(!empty($_SESSION['currentUser'])){
	relocate('http://localhost/php-projects/auth-system/pages/profile.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(empty($_POST['login'])) {
		$errors['login'] = 'Login is empty';
	}
	if(empty($_POST['password'])) {
		$errors['password'] = 'Password is empty';
	}

	if(!$errors){
		$db = new MySqlHelper();
		$user = $db->getUserByLoginAndPassword($_POST['login'], $_POST['password']);
		if(!is_null($user)){
			if(session_status() == PHP_SESSION_NONE)
				session_start();

			$_SESSION['currentUser'] = $user;
			relocate('http://localhost/php-projects/auth-system/pages/profile.php');
		}
		else{
			$errors['common'] = "Wrong login or password";
		}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<meta charset="utf-8">
		<link href="../styles/custom-text.css" rel="stylesheet"/>
		<link href="../styles/buttons.css" rel="stylesheet"/>
		<link href="../styles/error.css" rel="stylesheet"/>
		<link href="../styles/main.css" rel="stylesheet"/>
	</head>
	<body>
		<div class="login-block block">
			<h2 class="login-block__title title">Login form</h2>
			<div class="login-block__login-form-block form-block">
				<form class="login-block__login-form" action="" method="post">
					<div class="login-block__input-text-block input-text-block">
						<input class="login-block__input-text-name input-text" value="<?php if(isset($_POST['login'])) echo($_POST['login']); else echo("")?>" placeholder="" name="login" type="text"/>
						<label class="login-block__text-label text-label">Login</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['login'])) echo $errors['login'];?>	
							</p>
						</div>
					</div>
					<div class="login-block__input-text-block input-text-block">
						<input class="reg-block__input-text-password input-text" vvalue="<?php if(isset($_POST['password'])) echo($_POST['password']); else echo("")?>" placeholder="" name="password" type="password"/>
						<label class="login-block__text-label text-label">Password</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?php if(isset($errors['password'])) echo $errors['password']?>	
							</p>
						</div>
					</div>
					<div class="reg-block__buttons-block">
						<div class="buttons-block__submit-button">
							<input type="submit" value="Sign in"/>
						</div>
						<div class="buttons-block__back-button">
							<a draggable="false" href="reg.php">Registration</a>
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
