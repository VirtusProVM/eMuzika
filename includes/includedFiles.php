<?php 

	if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		include("includes/config.php");
		include("classes/User.php");
		include("classes/Artists.php");
		include("classes/Album.php");
		include("classes/Songs.php");
		include("classes/Playlist.php");


		if(isset($_GET['userLoggedIn'])) {
			$userLoggedIn = new User($conn, $_GET['userLoggedIn']);
		} else {
			echo "Username invalid!!! Check openPage in JS file";
			exit();
		}


	} else {
		include("includes/header.php");
		include("includes/footer.php");

		$url = $_SERVER['REQUEST_URI'];
		echo "<script>openPage('$url')</script>";
		exit();
	}

 ?>