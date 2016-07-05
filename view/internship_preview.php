<?php
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

            <a href="<?php echo __SITE_URL; ?>/index.php?rt=students"><button>Sve prakse!</button></a>
		</span>

		<?php

	}
	else{
		?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/loginForm"><button>Login</button></a>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/registerForm"><button>Registracija</button></a>
        <a href="<?php echo __SITE_URL; ?>/index.php?rt=students"><button>Sve prakse</button></a>
		<?php
	}
?>

<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<?php
    echo '<div id="internship">';
    foreach ($companiesList as $company) {
        if($company->cid === $internship->cid){
            echo '<h2>Tvrtka </h2><p>' . htmlentities($company->name, ENT_QUOTES) . '</p>';
            break;
        }
    }
    echo '<h2>Opis </h2><p>' . htmlentities($internship->description, ENT_QUOTES) . '</p>';
    echo '<h2>Uvjeti </h2><p>' . htmlentities($internship->requirements, ENT_QUOTES) . '</p>';

    echo '</div>';

    if(isset($_SESSION['sid'])){
?>

        <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/applyForm" style='display:inline;'>
            <input type="hidden" name="iid" value="<?php echo $internship->iid;?>"/>
            <button type="submit">Prijavi se!</button>
        </form>
<?php
    }
?>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/students.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
