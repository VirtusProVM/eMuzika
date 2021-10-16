var currentPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var shufflePlaylist = [];
var tempPlaylist = [];
var userLoggedIn;
var timer; 

$(document).click(function(click) {
	var target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionButton")) {
		hideOptionsMenu();
	}
});

$(window).scroll(function() {
	hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
	var select = $(this);
	var playlistId = select.val();
	var songId = select.prev("songId").val();

	$.post("includes/addToPlaylist.php", { playlistId: playlistId , songId: songId }).done(function(errorMsg) {

		if(errorMsg != "") {
			alert(errorMsg);
			return;
		}

		hideOptionsMenu();
		select.val("");
	});
});

function updateEmail(email) {
	var emailValue = $("." + email).val();

	$.post("includes/updateEmail.php", { email : email, username : userLoggedIn }).done(function(response) {
		$("." + email).nextAll(".message").text(response);
	});
}

function updatePassword(oldPasswordClass, newPasswordClass, confirmPasswordClass) {
	var oldPassword = $("." + oldPasswordClass).val();
	var newPassword = $("." + newPasswordClass).val();
	var confirmPassword = $("." + confirmPasswordClass).val();

	$.post("includes/updatePassword.php", 
		{ oldPassword: oldPassword, 
			newPassword: newPassword, 
			confirmPassword: confirmPassword,
			username : userLoggedIn}).done(function(response) {
				$("." + oldPasswordClass).nextAll(".message").text(response);
			});

}

function logout() {
	$.post("handlers/logout.php", function() {
		location.reload();
	})
}

function openPage(url) {

	if(timer != null) {
		clearTimeout(timer);
	}

	if(url.indexOf("?") == -1) {
		url = url + "?";
	}

	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

function createPlaylist() {
	var errorMsg = prompt("Create your playlist!!!");

	if(errorMsg != null) {
		$.post("includes/createPlaylist.php", { name : errorMsg, username : userLoggedIn }).done(function(error) {
			if(errorMsg != "") {
				alert(error);
				return;
			}

			openPage("yourmusic.php");
		});
	}
}

function deletePlaylist(playlistID) {
	var msg = confirm("Delete playlist?");

	if(msg == true) {
		$.post("includes/deletePlaylist.php", { playlistID : playlistID }).done(function(error) {
			if(msg != "") {
				alert(error);
				return;
			}

			openPage("yourmusic.php");

		});
	}
}

function removeFromPlaylist(button, playlistId) {
	var songId = $(button).prevAll(".songId").val();

	$.post("includes/removeFromPlaylist.php", { playlistId : playlistId, songId : songId }).done(function(error) {

		if(error != "") {
			alert(error);
			return;
		}

		openPage("playlist.php?id=" + playlistId);

	});
}

function hideOptionsMenu() {
	var menu = $(".optionsMenu");

	if(menu.css("display") != "none") {
		menu.css("display", "none");
	}
}

function showOptionsMenu(button) {
	var songId = $(button).prevAll(".songId").val();
	var menu = $(".optionsMenu");
	var menuWidth = menu.width();
	menu.find(".songId").val(songId);

	var scrollTop = $(window).scrollTop();
	var elementOffset = $(button).offset().top;

	var top = elementOffset - scrollTop;

	var left = $(button).position().left;

	menu.css({"top": top + "px", "left": left - menuWidth + "px", "display": "inline"});
}

function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60);
	var seconds = time - (minutes * 60);

	var extraZero;

	if(seconds < 10) {
		extraZero = "0";
	} else {
		extraZero = "";
	}

	return minutes + ":" + extraZero + seconds;
}

function updateDurationProgressBar(audio) {
	$(".progressTime.currentTime").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime - audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {
	this.currentPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("canplay", function() {
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("timeupdate", function() {
		if(this.duration) {
			updateDurationProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});

	this.setTrack = function (track) {
		this.currentPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function (seconds) {
		this.audio.currentTime = seconds;
	}
}