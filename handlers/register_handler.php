<?php 
	
	function sanitizeFormUsername($inputText) {
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);

		return $inputText;
	}

	function sanitizeFormString($inputText) {
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		$inputText = ucfirst(strtolower($inputText));

		return $inputText;
	}


	function sanitizeFormPassword($inputText) {
		$inputText = strip_tags($inputText);

		return $inputText;
	}


	if (isset($_POST['registerButton'])) {
		
		$username = sanitizeFormUsername($_POST['username']);

		$firstname = sanitizeFormString($_POST['firstname']);

		$lastname = sanitizeFormString($_POST['lastname']);

		$email = sanitizeFormUsername($_POST['email1']);

		$email2 = sanitizeFormUsername($_POST['email2']);

		$password = sanitizeFormPassword($_POST['password1']);

		$password2 = sanitizeFormPassword($_POST['password2']);

		$wasSuccesful = $account -> register($username, $firstname, $lastname, $email, $email2, $password, $password2);

		if($wasSuccesful == true) {
			$_SESSION['userLoggedIn'] = $username;
			header("Location: index.php");
		}
	}
 ?>