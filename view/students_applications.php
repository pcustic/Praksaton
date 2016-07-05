<?php
	if(isset($_SESSION['name'])){
		echo '<p class="osobno">' . $_SESSION['name'] . '</p>';

		?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/profile"><button>Uredi profil</button></a>

		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/logoutForm"><button>Log out</button></a>

<?php require_once __SITE_PATH . '/view/_header.php'; ?>

		<span class="navBar">
			<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=students/search" style='display:inline;'>
				<input type="text" name="query" id="searchText"/>
				<button type="submit" id="searchButton">Traži praksu!</button>
			</form>

            <a href="<?php echo __SITE_URL; ?>/index.php?rt=students"><button>Sve prakse!</button></a>
		</span>

		<?php

	}
	else{
		?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/loginForm"><button>Login</button></a>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/registerForm"><button>Registracija</button></a>
		<?php
	}
?>

<?php
	if($internshipList == false){
		echo "<p>Nažalost, tu nema niti jedne prijave :( <br/>
		<br/>Prijavite se na neku praksu!</p>";
	}
	else{
		echo '<table class="internship"><tr>
		<th>Ime prakse</th>
		<th>Status</th>
		</tr>';
		foreach( $internshipList as $internship ){
			echo '<tr><td>' . $internship->title .
				'</td>';
			foreach ($applicationList as $application) {
				if($application->iid === $internship->iid){
					echo '<td>' . $application->status . '</td></tr>';
					break;
				}
			}
		}
		echo '</table>';
	}
?>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/students.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
