<?php 
include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$artistID = $_GET['id'];
} else {
	header("Location: index.php");
}

$artist = new Artists($conn, $artistID);
?>

<div class="entityInfo borderBottom">
	
	<div class="centerSection">
		
		<div class="artistInfo">
			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>

			<div class="headerButton">
				<button class="button green" onclick="playFirstSong();">PLAY</button>
			</div>
		</div>

	</div>

</div>

<div class="trackListContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="trackList">
		<?php 
			$songId = $artist->getSongID();

			$i = 1;
			foreach ($songId as $songs) {

				if($i > 5) {
					break;
				}

				$albumSong = new Songs($conn, $songs);
				$albumArtists = $albumSong->getArtist();

				echo "<li class='trackListRow'>
					<div class='trackCount'>
						<img class='play' src='https://img.icons8.com/ios/50/000000/circled-play--v2.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'/>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtists->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $albumSong->getId() . "' />
						<img class='optionButton' src='https://img.icons8.com/ios/50/000000/more.png'
							onclick='showOptionsMenu(this)'/>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>
				</li>";
				$i = $i + 1;
			}
		 ?>

		 <script>
		 	
		 	var tempSongId = '<?php echo json_encode($songId); ?>';
		 	tempPlaylist = JSON.parse(tempSongId);
		 </script>

	</ul>
</div>

<div class="gridViewContainer">
	<h2>ALBUMS</h2>
	<?php 
		$albumQuery = mysqli_query($conn, "SELECT * FROM albums WHERE artist='$artistID'");

		while ($row = mysqli_fetch_array($albumQuery)) {



			echo "<div class='gridViewItem'>
				<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
				<img src='" . $row['artworkPath'] ."' />

				<div class='gridViewInfo'>"
					. $row['title'] .
				"</div>
				</span>
			</div>";


		}
	 ?>

</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getDropdownOptionsMenu($conn, $userLoggedIn->getUsername()); ?>
</nav>