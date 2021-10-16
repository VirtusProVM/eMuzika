<?php 
	class Songs {

		private $conn;
		private $id;
		private $mysqliData;
		private $title;
		private $artistID;
		private $albumID;
		private $genre;
		private $duration;
		private $path;
		
		public function __construct($conn, $id) {
			$this -> conn = $conn;
			$this -> id = $id;

			$query = mysqli_query($this -> conn, "SELECT * FROM songs WHERE id = '$this->id'");
			$this -> mysqliData = mysqli_fetch_array($query);
			$this -> title = $this -> mysqliData['title'];
			$this -> artistID = $this -> mysqliData['artist'];
			$this -> albumID = $this -> mysqliData['album'];
			$this -> genre = $this -> mysqliData['genre'];
			$this -> duration = $this -> mysqliData['duration'];
			$this -> path = $this -> mysqliData['path'];
	}

	public function getTitle() {
		return $this -> title;
	}

	public function getId() {
		return $this -> id;
	}

	public function getArtist() {
		return new Artists($this -> conn, $this -> artistID);
	}

	public function getAlbum() {
		return new Album($this -> conn, $this -> albumID);
	}

	public function getGenre() {
		return $this -> genre;
	}

	public function getDuration() {
		return $this -> duration;
	}

	public function getPath() {
		return $this -> path;
	}
}
 ?>