<?php
//ako session postoji ispisi ime, button za logout,
	if(isset($_SESSION['cname'])){
		echo '<p class="osobno">' . $_SESSION['cname'] . '</p>';

?>
		<a href="<?php echo __SITE_URL; ?>/index.php?rt=companies/logoutForm"><button>Log out</button></a>

		<br/>
<?php
    }
?>

<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<?php echo '<p>' . $msg . '</p>'; ?>

<a href="<?php echo __SITE_URL; ?>/index.php?rt=companies"><button>Vrati se na prakse</button></a>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
