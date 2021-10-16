<?php 

	$songQuery = mysqli_query($conn, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

	$resultArray = array();

	while($row = mysqli_fetch_array($songQuery)) {
		array_push($resultArray, $row['id']);
	}

	$jsonArray = json_encode($resultArray);

 ?>

 <script>
 	
 	
 	$(document).ready(function() {
 		var newPlaylist = <?php echo $jsonArray; ?>;
 		audioElement = new Audio();
 		setTrack(newPlaylist[0], newPlaylist, false);

		updateVolumeProgressBar(audioElement.audio);

		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
			e.preventDefault();
		});

 		$(".playbackBar .progressBar").mousedown(function() {
 			mouseDown = true;
 		});

 		$(".playbackBar .progressBar").mousemove(function(e) {
 			if(mouseDown == true) {
 				timeFromOffset(e, this);
 			}
 		});

 		$(".playbackBar .progressBar").mouseup(function(e) {
 			timeFromOffset(e, this);
 		});

 		$(".volumeBar .progressBar").mousedown(function() {
 			mouseDown = true;
 		});

 		$(".volumeBar .progressBar").mousemove(function(e) {
 			if(mouseDown == true) {
 				var percentage = e.offsetX / $(this).width();

 				if(percentage >= 0 && percentage <= 1) {
 					audioElement.audio.volume = percentage;
 				}
 			}
 		});

 		$(".volumeBar .progressBar").mouseup(function() {
			var percentage = e.offsetX / $(this).width();

			if(percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
 		});


 		$(document).mouseup(function() {
 			mouseDown = false;
 		});
 	});

 	function timeFromOffset(mouse, progressBar) {
 		var percentage = mouse.offsetX / $(progressBar).width() * 100;
 		var seconds = audioElement.audio.duration * (percentage / 100);
 		audioElement.setTime(seconds);
 	}

 	function previousSong() {
 		if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
 			audioElement.setTime(0);
 		} else {
 			currentIndex = currentIndex - 1;
 			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
 		}
 	}

	function nextSong() {

		if(repeat == true) {
			audioElement.setTime(0);
			playSong();
			return;
		}

		if(currentIndex == currentPlaylist.length - 1) {
			currentIndex = 0;
		} else {
			currentIndex++;
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
	}

	function setRepeat() {
		repeat = !repeat;
		var imgButton = repeat ? "https://img.icons8.com/office/40/000000/repeat.png" : "https://img.icons8.com/ios/50/000000/repeat.png";
		$(".buttonControl.repeat img").attr("src", imgButton);
	}

	function setMute() {
		audioElement.audio.muted = !audioElement.audio.muted;
		var volumeImage = audioElement.audio.muted ? "https://img.icons8.com/ios/50/000000/mute--v1.png" : "https://img.icons8.com/ios/50/000000/high-volume--v2.png";
		$(".buttonControl.volume img").attr("src", volumeImage);
	}

	function setShuffle() {
		shuffle = !shuffle;
		var imageName = shuffle ? "https://img.icons8.com/emoji/48/000000/shiffle-tracks-button-emoji.png" : "https://img.icons8.com/ios/50/000000/shuffle.png";
		$(".buttonControl.schuffle img").attr("src", imageName);

		if(shuffle == true) {
			shuffleArray(shufflePlaylist);
			currentIndex = shufflePlaylist.indexOf(audioElement.currentPlaying.id);
		} else {
			currentIndex = currentPlaylist.indexOf(audioElement.currentPlaying.id);
		}
	}

	function shuffleArray(argument) {
		var j, x, i;

		for(i = argument.length; i; i--) {
			j = Math.floor(Math.random() * i);
			x = argument[i - 1];
			argument[i - 1] = argument[j];
			argument[j] = x;
		}
	}


 	function setTrack(trackId, newPlaylist, play) {

 		if(newPlaylist != currentPlaylist) {
 			currentPlaylist = newPlaylist;
 			shufflePlaylist = currentPlaylist.slice();
 			shuffleArray(shufflePlaylist);
 		}

 		if(shuffle == true) {
 			currentIndex = shufflePlaylist.indexOf(trackId);
 		} else {
 			currentIndex = currentPlaylist.indexOf(trackId);
 		}

 		pauseSong();

 		$.post("includes/getSongJson.php", { songId: trackId }, function(data) {

 			var track = JSON.parse(data);
 			
			$(".trackName span").text(track.title);

			$.post("includes/getArtistName.php", { artistId : track.artist}, function(data) {
				var artist = JSON.parse(data);

				$(".trackInfo .artistName span").text(artist.name);
				$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
			});

			$.post("includes/getAlbumJson.php", { albumId : track.album }, function(data) {
				var album = JSON.parse(data);

				$(".content .albumLink img").attr("src", album.artworkPath);
				$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
				$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			});

 			audioElement.setTrack(track);

 			if(play == true) {
 				playSong();
 			}
 		});
 		
 		
 	}

 	function playSong() {

 		if(audioElement.audio.currentTime == 0) {
 			$.post("includes/updatePlays.php", { songId: audioElement.currentPlaying.id });

 		}

 		$(".buttonControl.play").hide();
 		$(".buttonControl.pause").show();
 		audioElement.play();
 	}

 	function pauseSong() {
 		$(".buttonControl.play").show();
 		$(".buttonControl.pause").hide();
 		audioElement.pause();
 	}

 </script>

<div id="nowPlayingBarContainer">
	<div id="nowPlayingBar">
		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					 <img role="link" tabindex="0" src="" class="albumArtwork">
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span role="link" tabindex="0"></span>
					</span>
					<span class="artistName">
						<span role="link" tabindex="0"></span>
					</span>
				</div>
				
			</div>
		</div>

		<div id="nowPlayingCenter">
			
		<div class="playerControls content">
			
			<div class="buttons">
				<button class="buttonControl schuffle" title="Shuffle button" onclick="setShuffle()">
					<img class="albumArtwork" src="https://img.icons8.com/ios/50/000000/shuffle.png" alt="schuffle" />
				</button>

				<button class="buttonControl previous" title="Previous button" onclick="previousSong()">
					<img src="https://img.icons8.com/ios/50/000000/skip-to-start--v2.png" alt="skipToStart" />
				</button>

				<button class="buttonControl play" title="Play button" onclick="playSong()">
					<img src="https://img.icons8.com/ios/50/000000/play--v3.png" alt="play" />
				</button>

				<button class="buttonControl pause" title="Pause button" style="display: none;" onclick="pauseSong()">
					<img src="https://img.icons8.com/ios/50/000000/pause--v1.png" alt="pause" />
				</button>

				<button class="buttonControl next" title="Next button" onclick="nextSong()">
					<img src="https://img.icons8.com/ios/50/000000/end--v2.png" alt="next" />
				</button>

				<button class="buttonControl repeat" title="Repeat button" onclick="setRepeat()">
					<img src="https://img.icons8.com/ios/50/000000/repeat.png" alt="repeat" />
				</button>
			</div>

			<div class="playbackBar">
				<span class="progressTime currentTime">0.00</span>
				<div class="progressBar">
					<div class="progressBarBackground">
						<div class="progress"></div>
					</div>
				</div>
				<span class="progressTime remaining">0.00</span>
			</div>

		</div>

		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar">
				<button class="buttonControl volume" title="Volume button" onclick="setMute()">
					<img src="https://img.icons8.com/ios/50/000000/high-volume--v2.png" alt="Volume" />
				</button>

				<div class="progressBar">
					<div class="progressBarBackground">
						<div class="progress"></div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>