<?php
//ako session postoji ispisi ime, button za logout, trazilicu, button za pregled svojih prijava
//inace ispisi button za login i registraciju
	if(isset($_SESSION['name'])){
		echo '<p class="osobno">' . $_SESSION['name'] . '</p>';

		?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/profile"><button>Uredi profil</button></a>

		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/logoutForm"><button>Log out</button></a>

		<span class="navBar">
			<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=students/search" style='display:inline;'>
				<input type="text" name="query" id="searchText"/>
				<button type="submit" id="searchButton">Traži praksu!</button>
			</form>

			<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/applications"><button>Pregledaj svoje prijave!</button></a>
		</span>

		<?php
		if(isset($search)){
		?>
			<a href="<?php echo __SITE_URL; ?>/index.php?rt=students"><button>Sve prakse!</button></a>

		<?php
		}
	}
	else{
		?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/loginForm"><button>Login</button></a>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/registerForm"><button>Registracija</button></a>
		<a href="<?php echo __SITE_URL; ?>"><button>Početna</button></a>
		<?php
	}
?>

<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<?php
//ispisi popis praksi
	if(isset($search) && $internshipList == false){
		echo "<p>Nažalost, pretraga nije dala niti jedan rezultat :( <br/> Molimo pokušajte ponovno sa nekim drugim upitom.</p>";
	}
	else{
		echo '<div class="internship"><table>';
		foreach( $internshipList as $internship ){
			echo '<tr><td><h2 style="display:inline;">' .
				$internship->title .
				'</h2>';
			foreach ($companiesList as $company) {
				if($company->cid === $internship->cid){
					echo '<p>' . $company->name . '</p>';
					break;
				}
			}
			echo '</td>';
?>
			<td>
			<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/preview" style='display:inline;'>
				<input type="hidden" name="iid" value="<?php echo $internship->iid;?>"/>
				<button type="submit">Pregledaj!</button>
			</form>
			</td>
<?php
			if(isset($_SESSION['sid'])){
?>
				<td>
				<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/applyForm" style='display:inline;'>
					<input type="hidden" name="iid" value="<?php echo $internship->iid;?>"/>
					<button type="submit">Prijavi se!</button>
				</form>
				</td>
<?php
			}
		}
		echo '</div></table>';
	}
?>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/students.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
