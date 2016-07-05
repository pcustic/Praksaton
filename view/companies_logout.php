<?php
//ako session postoji ispisi ime, button za logout,
	if(isset($_SESSION['cname'])){
		echo '<p class="osobno">' . $_SESSION['cname'] . '</p>';
    }
?>

<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<h2>Jeste li sigurni da se želite odjaviti?</h2>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=companies/logout" style='display:inline;'>
    <input type="hidden" name="logout"/>
    <button type="submit">Odjava</button>
</form>

<a href="<?php echo __SITE_URL; ?>/index.php?rt=companies"><button>Vrati se na prakse</button></a>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
