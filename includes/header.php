<?php 

	include("includes/config.php");
	include("classes/Artists.php");
	include("classes/Album.php");
	include("classes/Songs.php");
	include("classes/User.php");
	include("classes/Playlist.php");

	//session_destroy(); LOGOUT

	if(isset($_SESSION['userLoggedIn'])) {
		$userLoggedIn = new User($conn, $_SESSION['userLoggedIn']);
		$username = $userLoggedIn->getUsername();
		echo "<script>userLoggedIn = '$username';</script>";
	} else {
		header("Location: register.php");
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to My Spotify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>
<body>

	<div id="mainContainer">

		<div id="topContainer">
			
			<?php include("includes/navbar.php"); ?>

			<div id="mainViewContainer">
				

				<div id="mainContent">