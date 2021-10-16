<?php 
include("includes/includedFiles.php");

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
} else {
	$term = "";
}

?>


<div class="searchContainer">
	<h4>Search for album, song, artist</h4>
	<input type="text" class="searchBox" value="<?php echo $term; ?>" placeholder="Start searching..." 
			onfocus="this.value = this.value" >
</div>

<script>

	$(".searchBox").focus();
	
	$(function() {
		var timer;

		$(".searchBox").keyup(function() {
			clearTimeout(timer);

			timer = setTimeout(function() {
				var val = $(".searchBox").val();
				openPage("search.php?term=" + val);
			}, 2000);
		});
	}); 

</script>

<?php if($term == "") exit(); ?>


<div class="trackListContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="trackList">
		<?php 


		$songsQuery = mysqli_query($conn, "SELECT id FROM songs WHERE title LIKE '$term%'");

		if(mysqli_num_rows($songsQuery) == 0) {
			echo "<span class='noResults'>No song found matching " . $term . "</span>";
		}

			$songArray = array();

			$i = 1;
			while ($row = mysqli_fetch_array($songsQuery)) {

				if($i > 15) {
					break;
				}

				array_push($songArray, $row['id']);

				$albumSong = new Songs($conn, $row['id']);
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
		 	
		 	var tempSongId = '<?php echo json_encode($songArray); ?>';
		 	tempPlaylist = JSON.parse(tempSongId);
		 </script>

	</ul>
</div>

<div class="artistContainer borderBottom">
	 <h2>ARTISTS</h2>

	 <?php 
	 	$artistQuery = mysqli_query($conn, "SELECT id FROM artists WHERE name LIKE '$term%'");

	 	if(mysqli_num_rows($artistQuery) == 0) {
			echo "<span class='noResults'>No artist found matching " . $term . "</span>";
		}

		while ($row = mysqli_fetch_array($artistQuery)) {
			$artistsFound = new Artists($conn, $row['id']);

			echo "<div class='searchResultRow'>
				<div class='artistName'>

					<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistsFound->getId() ."\")'>
						"
							. $artistsFound->getName() .
						"
					 </span>

				</div>

			</div>";
		}
	  ?>
</div>


<div class="gridViewContainer">
	<h2>ALBUMS</h2>
	<?php 
		$albumQuery = mysqli_query($conn, "SELECT * FROM albums WHERE title LIKE '$term%'");

		if(mysqli_num_rows($albumQuery) == 0) {
			echo "<span class='noResults'>No albums found matching " . $term . "</span>";
		}

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