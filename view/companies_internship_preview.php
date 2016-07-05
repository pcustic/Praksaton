<?php
//ako session postoji ispisi ime, button za logout,
	if(isset($_SESSION['cname'])){
		echo '<p class="osobno">' . $_SESSION['cname'] . '</p>';

?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=companies/logoutForm"><button>Log out</button></a>

		<br/><br/>
		<span>
			<a href="<?php echo __SITE_URL; ?>/index.php?rt=companies"><button>Sve prakse</button></a>
		</span>
<?php
    }
?>

<?php require_once __SITE_PATH . '/view/_header.php'; ?>


<?php
    echo '<div id="internship">';
    echo '<h2>Opis </h2><p>' . htmlentities($internship->description, ENT_QUOTES) . '</p>';
    echo '<h2>Uvjeti </h2><p>' . htmlentities($internship->requirements, ENT_QUOTES) . '</p>';

    echo '</div>';
?>
	<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/delete" style='display:inline;'>
		<input type="hidden" name="iid" value="<?php echo $internship->iid;?>"/>
		<button type="submit">Ukloni</button>
	</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
