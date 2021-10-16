<?php 
	include ("includes/config.php");
	include ("classes/Account.php");
	include ("classes/Constants.php");

	$account = new Account($conn);

	include ("handlers/register_handler.php");
	include ("handlers/login_handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
 ?>

<html>
<head>
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="assets/css/mycss.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

	<?php 
		if (isset($_POST['registerButton'])) {
			echo '<script>
						$(document).ready(function() {
						
							$("#loginform").hide();
							$("#registerform").show();
						});
					</script>';
		} else {
			echo '<script>
						$(document).ready(function() {
						
							$("#loginform").show();
							$("#registerform").hide();
						});
					</script>';
		}
	 ?>

	<div id="background">

		<div id="login_container">

			<div id="inputcontainer">
				<form id="loginform" action="register.php" method="POST">
					<h2>Login to your account</h2>

					<p>
						<?php echo $account -> getError(Constants::$loginError); ?>
						<label for="loginUsername">Username</label>
						<input type="text" name="loginUsername" id="loginUsername" placeholder="Enter your username..."
						value="<?php getInputValue('loginUsername') ?>" required>
					</p>

					<p>
						<label for="loginPassword">Passoword</label>
						<input type="password" name="loginPassword" id="loginPassword" required>				
					</p>
					
					<button type="submit" name="loginButton">LOG IN</button>

					<div class="hasAccountText">
						<span id="hideLogIn">Don't have an account yet?</span>
					</div>
				</form>


				<form id="registerform" action="register.php" method="POST">
					<h2>Create your free account</h2>

					<p>
						<?php echo $account -> getError(Constants::$usernameCharacter); ?>
						<?php echo $account -> getError(Constants::$usernameExist); ?>
						<label for="loginUsername">Username</label>
						<input type="text" name="username" id="username" placeholder="Enter your username..." value="<?php getInputValue('username') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$firstnameCharacter); ?>
						<label for="firstname">Firstname</label>
						<input type="text" name="firstname" id="firstname" placeholder="Enter your firstname..." value="<?php getInputValue('firstname') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$lastnameCharacter); ?>
						<label for="lastname">Lastname</label>
						<input type="text" name="lastname" id="lastname" placeholder="Enter your lastname..." value="<?php getInputValue('lastname') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$emailDontMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailExist); ?>
						<label for="email1">Email</label>
						<input type="email" name="email1" id="email1" placeholder="Enter your email..." value="<?php getInputValue('email1') ?>" required>
					</p>

					<p>
						<label for="email2">Confirm Email</label>
						<input type="email" name="email2" id="email2" placeholder="Confirm your email..." value="<?php getInputValue('email2') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$passwordDontMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacter); ?>
						<label for="password1">Passoword</label>
						<input type="password" name="password1" id="password1" required>				
					</p>

					<p>
						<label for="password2">Passoword</label>
						<input type="password" name="password2" id="password2" required>				
					</p>
					
					<button type="submit" name="registerButton">REGISTER</button>

					<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Login here.</span>
					</div>

				</form>

			</div>

			<div id="loginText">
				<h1>GREAT MUSIC. YOUR MUSIC</h1>
				<h2>Listen songs for free</h2>

				<ul>
					<li>Discover music</li>
					<li>Create your own playlist</li>
					<li>Follow artist to keep to date.</li>
				</ul>
			</div>

		</div>
	</div>

</body>
</html>