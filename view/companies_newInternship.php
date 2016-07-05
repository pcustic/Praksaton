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

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=internships/add">
    <table class="internship">
        <input type="hidden" name="cid" value="<?php echo $_SESSION['cid'];?>"/>
        <tr><td>
            <label for="title">Naziv prakse:</label>
        </td><td>
            <input type="text" name="title"/>
        </td></tr>

        <tr><td>
            <label for="description">Opis:</label>
        </td><td>
            <textarea name="description" rows="7" cols="50" ></textarea>
        </td></tr>

        <tr><td>
            <label for="requirements">Uvjeti:</label>
        </td><td>
            <textarea name="requirements" rows="7" cols="50" ></textarea>
        </td></tr>
    </table>
    <br/>
	<p id="error"></p>
    <button type="submit">Stvori praksu</button>
</form>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/companies_newInternship.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
