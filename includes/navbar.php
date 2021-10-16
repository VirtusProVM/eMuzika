<div id="navbarContainer">
	<nav class="navbar">
		<span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
			<img src="https://img.icons8.com/ios-glyphs/30/000000/cobra.png"/>
		</span>

		
		<div class="group">
			
			<div class="navItems">
				<span role="link" tabindex="0" onclick="openPage('search.php');" class="navItemLink">Search
					<img src="https://img.icons8.com/material-outlined/24/000000/search--v1.png" class="icon" alt="search" />
				</span>
			</div>


		</div>

		<div class="group">
			
			<div class="navItems">
				<span role="link" tabindex="0" onclick="openPage('browse.php');" class="navItemLink">Browse</span>
			</div>

			<div class="navItems">
				<span role="link" tabindex="0" onclick="openPage('yourmusic.php')" class="navItemLink">Your music</span>
			</div>

			<div class="navItems">
				<span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"><?php echo $userLoggedIn->getFullname(); ?></span>
			</div>

		</div>
	</nav>

</div>