<?php include("includes/includedFiles.php"); ?>

<?php 
	if (isset($_GET['id'])) {
		$playlistID = $_GET['id'];
	} else {
		header("Location: index.php");
	}

$playlist = new Playlist($conn, $playlistID);
$owner = new User($conn, $playlist->getOwner());
?>

<div class="entityInfo">
	
	<div class="leftSection">
		<div class="playlistImage">
			<img src="https://img.icons8.com/ios-glyphs/60/000000/music-transcript.png">
		</div>
		
	</div>

	<div class="rightSection">
		<h1><?php echo $playlist->getName(); ?></h1>
		<span><?php echo $playlist->getOwner(); ?></span>
		<p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
		<button class="button" onclick="deletePlaylist('<?php echo $playlistID ?>')">Delete playlist</button>
	</div>
</div>

<div class="trackListContainer">
	<ul class="trackList">
		<?php 
			$songId = $playlist->getSongsIDs();

			$i = 1;
			foreach ($songId as $songs) {
				$playlistSong = new Songs($conn, $songs);
				$songArtists = $playlistSong->getArtist();

				echo "<li class='trackListRow'>
					<div class='trackCount'>
						<img class='play' src='https://img.icons8.com/ios/50/000000/circled-play--v2.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'/>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $playlistSong->getTitle() . "</span>
						<span class='artistName'>" . $songArtists->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $playlistSong->getId() . "' />
						<img class='optionButton' src='https://img.icons8.com/ios/50/000000/more.png'
							onclick='showOptionsMenu(this)'/>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $playlistSong->getDuration() . "</span>
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

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getDropdownOptionsMenu($conn, $userLoggedIn->getUsername()); ?>
</nav>