<?php 
include("C:/xampp/htdocs/MySpotify/includes/config.php");

if(isset($_POST['songId'])) {
	$songId = $_POST['songId'];

	$query = mysqli_query($conn, "UPDATE songs SET plays = plays + 1 WHERE id='$songId'");

}

 ?>