<?php  
	
	class Playlist {


		private $id;
		private $conn;
		private $name;
		private $owner;
		
		public function __construct($conn, $data) {

			if(!is_array($data)) {
				$query = mysqli_query($conn, "SELECT * FROM playlist WHERE id='$data'");
				$data = mysqli_fetch_array($query);
			}

			$this->id = $data['id'];
			$this->conn = $conn;
			$this->name = $data['name'];
			$this->owner = $data['owner'];
		}

		public function getId() {
			return $this->id;
		}

		public function getOwner() {
			return $this->owner;
		}

		public function getName() {
			return $this->name;
		}

		public function getNumberOfSongs() {
			$query = mysqli_query($this->conn, "SELECT songID FROM songslist WHERE playlistID='$this->id'");
			return mysqli_num_rows($query);
		}

		public function getSongsIDs() {
			$query = mysqli_query($this->conn, "SELECT songID FROM songslist WHERE playlistID = '$this->id' ORDER BY playlistOrder ASC");

			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['songID']);
			}

			return $array;
		}

		public static function getDropdownOptionsMenu($conn, $username) {
			$dropdown = '<select class="item playlist">
							<option>Add to playlist</option>';


			$query = mysqli_query($conn, "SELECT id, name FROM playlist WHERE owner='$username'");

			while($row = mysqli_fetch_array($query)) {
				$id = $row['id'];
				$name = $row['name'];

				$dropdown = $dropdown . "<option value='$id'>$name</option>";
			}


			return $dropdown . "</select>";
		}
	}
?>