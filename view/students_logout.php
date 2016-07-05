<?php
	if(isset($_SESSION['name'])){
		echo '<p class="osobno">' . $_SESSION['name'] . '</p>';

		?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/profile"><button>Uredi profil</button></a>
		<br/>

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
        //netko je rucno dosao ovdje
        header( 'Location: ' . __SITE_URL . '/index.php?rt=students');
        exit();
	}
?>

<h2>Jeste li sigurni da se želite odjaviti?</h2>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=students/logout" style='display:inline;'>
    <input type="hidden" name="logout"/>
    <button type="submit">Odjavi me!</button>
</form>

<a href="<?php echo __SITE_URL; ?>/index.php?rt=students"><button>Vrati me na prakse!</button></a>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/students.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
