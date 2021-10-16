<?php 
	class Album {
		private $conn;
		private $id;
		private $title;
		private $genre;
		private $artworkPath;
		private $artistsID;

		public function __construct($conn, $id) {
			$this -> conn = $conn;
			$this -> id = $id;

			$albumQuery = mysqli_query($this->conn, "SELECT * FROM albums WHERE id = '$this->id'");
			$album = mysqli_fetch_array($albumQuery);

			$this -> title = $album['title'];
			$this -> genre = $album['genre'];
			$this -> artworkPath = $album['artworkPath'];
			$this -> artistsID = $album['artist'];
		}

		public function getTitle() {
			return $this->title;
		}

		public function getArtworkPath() {
			return $this->artworkPath;
		}

		public function getArtists() {
			return new Artists($this->conn, $this->artistsID);
		}

		public function getGenre() {
			return $this->genre;
		}

		public function getNumberOfSongs() {
			$query = mysqli_query($this->conn, "SELECT id FROM songs WHERE album = '$this->id'");
			return mysqli_num_rows($query);
		}

		public function getSongID() {
			$query = mysqli_query($this->conn, "SELECT id FROM songs WHERE album = '$this->id' ORDER BY albumOrder ASC");

			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['id']);
			}
			return $array;
		}
	}
 ?>