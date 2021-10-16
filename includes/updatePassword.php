<?php  
include("C:/xampp/htdocs/MySpotify/includes/config.php");

if(!isset($_POST['username'])) {
	echo "ERROR updateEmail.php";
	exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword']) || !isset($_POST['confirmPassword'])) {
	echo "Not all password has been set";
	exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword'] == "" || $_POST['confirmPassword'] == "") {
	echo "Please fill fields";
	exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

$oldPass = md5($oldPassword);

$passwordCheck = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$oldPass'");
if(mysqli_num_rows($passwordCheck) != 1) {
	echo "Password is incorret";
	exit();
}

if($newPassword != $confirmPassword) {
	echo "Your new password do not match";
	exit();
}

if(preg_match('/[^A-Za-z0-9]/', $newPassword)) {
	echo "Your password must contains only letters and numbers ";
	exit();
}

if(strlen($newPassword) > 30 || strlen($newPassword) < 8) {
	echo "Your password must be between 8 and 30 characters";
	exit();
}

$newPass = md5($newPassword);

$query = mysqli_query($conn, "UPDATE user SET password='$newPass' WHERE username='$username'");
echo "Update successful";


?>