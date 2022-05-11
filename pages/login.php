<?php
namespace AuthSystem;
require_once('../helpers/MySqlHelper.php');
require_once('../helpers/SessionHelper.php');
require_once('../helpers/RelocationHelper.php');


$loginError = $passwordError = $commonError = "";



if(!empty($_SESSION['currentUser'])){
	relocate('http://localhost/php-projects/auth-system/pages/profile.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$errors = false;
	if(empty($_POST['login'])) {
		$loginError = 'Login is empty';
		$errors = true;
	}
	if(empty($_POST['password'])) {
		$passwordError = 'Password is empty';
		$errors = true;
	}

	if(!$errors){
		try {
			$db = new MySqlHelper();
			try {
				$user = $db->getUserByLoginAndPassword($_POST['login'], $_POST['password']);

				if(!is_null($user)){
					if(session_status() == PHP_SESSION_NONE)
						session_start();

					$_SESSION['currentUser'] = $user;
					relocate('http://localhost/php-projects/auth-system/pages/profile.php');
					die();
				}
				else{
					$commonError = "Wrong login or password";
				}
			}
			catch(DbOperationException $ex) {
				$commonError = "Authorization user error: ".$ex->getMessage();
			}	
		}
		catch(DbConnectionException $ex) {
			$commonError = "Database connection error: ".$ex->getMessage(); 
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
						<input class="login-block__input-text-name input-text" value="<?php if(isset($_POST['name'])) echo($_POST['name']); else echo("")?>" placeholder="" name="login" type="text"/>
						<label class="login-block__text-label text-label">Login</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?=$loginError?>	
							</p>
						</div>
					</div>
					<div class="login-block__input-text-block input-text-block">
						<input class="reg-block__input-text-password input-text" vvalue="<?php if(isset($_POST['password'])) echo($_POST['password']); else echo("")?>" placeholder="" name="password" type="password"/>
						<label class="login-block__text-label text-label">Password</label>
						<div class="input-text-block__error-block error-block">
							<p class="error-block__error-message">
								<?=$passwordError?>	
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
							<?=$commonError?>
						</p>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
