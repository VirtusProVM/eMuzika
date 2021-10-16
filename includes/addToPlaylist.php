<?php  

include("C:/xampp/htdocs/MySpotify/includes/config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];

	$orderQuery = mysqli_query($conn, "SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM songslist WHERE playlistID = '$playlistId'");
	$row = mysqli_fetch_array($orderQuery);
	$order = $row['playlistOrder'];

	$query = mysqli_query($conn, "INSERT INTO songslist VALUES('', '$songId', '$playlistId', '$order')");

} else {
	
	echo "Invalid addToPlaylist.php";
}

?>