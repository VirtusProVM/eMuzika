<?php  
include("C:/xampp/htdocs/MySpotify/includes/config.php");

if(isset($_POST['username'])) {
	echo "ERROR updateEmail.php";
	exit();
}

if(isset($_POST['email']) && $_POST['email'] != "") {
	$username = $_POST['username'];
	$email = $_POST['email'];

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Invalid email";
		exit();
	}

	$emailCheck = mysqli_query($conn, "SELECT email FROM users WHERE email='$email' AND username !='$username'");
	if(mysqli_num_rows($emailCheck)) {
		echo "Email already in use";
		exit();
	}

	$updateQuery = mysqli_query($conn, "UPDATE user SET email = '$email' WHERE username = '$username'");
	echo "Update successful";

} else {
	echo "You must provide an email";
}
?>