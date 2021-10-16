<?php  
include("C:/xampp/htdocs/MySpotify/includes/config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];

	$query = mysqli_query($conn, "DELETE FROM songslist WHERE playlistID='$playlistId' AND $songID='$songId'");

} else {
	echo "Invalid removeFromPlaylist.php";
}


?>