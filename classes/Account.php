<?php 
	
	class Account {

		private $conn;
		private $error_array;
		
		public function __construct($conn) {
			$this -> conn = $conn;
			$this -> error_array = array();
		}

		public function getError($error) {
			if(!in_array($error, $this->error_array)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
			$this -> validateUsername($un);
			$this -> validateFirstname($fn);
			$this -> validateLastname($ln);
			$this -> validateEmail($em, $em2);
			$this -> validatePassword($pw, $pw2);

			if(empty($this->error_array) == true) {
				return $this -> insertUserDetails($un, $fn, $ln, $em, $pw);
			} else {
				return false;
			}
		}

		public function login($username, $password) {
			$password = md5($password);

			$query = mysqli_query($this->conn, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
			if(mysqli_num_rows($query) == 1)  {
				return true;
			} else {
				array_push($this->error_array, Constants::$loginError);
				return false;
			}
		}

		private function insertUserDetails($un, $fn, $ln, $em, $pw) {
			$encryptedPassword = md5($pw);
			$profile_pic = "assets/images/profile_pic/default-profile-pic.png";
			$date = date("Y-m-d");

			$result = mysqli_query($this->conn, "INSERT INTO user VALUES ('', '$un', '$fn', '$ln', '$em',  '$encryptedPassword', '$date', '$profile_pic')");

			return $result;
		}

		private function validateUsername($username) {
			if(strlen($username) > 25 || strlen($username) < 5) {
				array_push($this->error_array, Constants::$usernameCharacter);
				return;
			}

			$checkUsernameQuery = mysqli_query($this->conn, "SELECT * FROM user WHERE username = '$username'");
			if(mysqli_num_rows($checkUsernameQuery) != 0) {
				array_push($this->error_array, Constants::$usernameExist);
			}
		}

		private function validateFirstname($firstname) {
			if(strlen($firstname) > 25 || strlen($firstname) < 2) {
				array_push($this->error_array, Constants::$firstnameCharacter);
				return;
			}
		}

		private function validateLastname($lastname) {
			if(strlen($lastname) > 25 || strlen($lastname) < 2) {
				array_push($this->error_array, Constants::$lastnameCharacter);
				return;
			}
		}

		private function validateEmail($email1, $email2) {
			if($email1 != $email2) {
				array_push($this->error_array, Constants::$emailDontMatch);
				return;
			} 

			if(!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
				array_push($this->error_array, Constants::$emailInvalid);
				return;
			}

			$checkEmailQuery = mysqli_query($this->conn, "SELECT email FROM user WHERE email = '$email1'");
			if(mysqli_num_rows($checkEmailQuery) != 0) {
				array_push($this->error_array, Constants::$emailExist);
				return;
			}


		}

		private function validatePassword($password1, $password2) {
			if($password1 != $password2) {
				array_push($this->error_array, Constants::$passwordDontMatch);
				return;
			}

			if(preg_match('/[^A-Za-z0-9]/', $password1)) {
				array_push($this->error_array, Constants::$passwordNotAlphanumeric);
				return;
			}

			if(strlen($password1) > 30 || strlen($password1) < 8) {
				array_push($this->error_array, Constants::$passwordCharacter);
				return;
			}
		}
	}
 ?>