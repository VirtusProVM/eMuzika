<?php include("includes/includedFiles.php"); ?>

<?php 
	if (isset($_GET['id'])) {
		$albumID = $_GET['id'];
	} else {
		header("Location: index.php");
	}


	$album = new Album($conn, $albumID);

	$artist = $album->getArtists();
	$artistID = $artist->getId();
 ?>

<div class="entityInfo">
	
	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>">
	</div>

	<div class="rightSection">
		<h1><?php echo $album->getTitle(); ?></h1>
		<span><?php echo $artist->getName(); ?></span>
		<p><?php echo $album->getNumberOfSongs(); ?> songs</p>
	</div>
</div>

<div class="trackListContainer">
	<ul class="trackList">
		<?php 
			$songId = $album->getSongID();

			$i = 1;
			foreach ($songId as $songs) {
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


<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getDropdownOptionsMenu($conn, $userLoggedIn->getUsername()); ?>
	<div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId ?>')">Remove from item</div>
</nav>
