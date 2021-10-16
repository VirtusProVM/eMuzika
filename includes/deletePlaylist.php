<?php  
include("C:/xampp/htdocs/MySpotify/includes/config.php");

if(isset($_POST['playlistID'])) {
	$playlistID = $_POST['playlistID'];

	$playlistQuery = mysqli_query($conn, "DELETE FROM playlist WHERE id='$playlistID'");
	$songsQuery = mysqli_query($conn, "DELETE FROM songslist WHERE playlistID='$playlistID'");

} else {
	echo "Playlist ID not good";
}

?>