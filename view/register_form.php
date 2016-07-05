<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="forma">
    <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=students/register">
    	<label for="name">Ime i prezime:</label>
        <input type="text" name="name" required/>
        <br/><br/>

        <label for="email">Email:</label>
        <input type="text" name="email" required/>
        <br/><br/>

        <label for="password">Lozinka:</label>
        <input type="password" name="password" required/>
        <br/><br/>

    	<button type="submit" class="login">Nastavi!</button>
    </form>
</div>

<br/>
<a href="<?php echo __SITE_URL; ?>/index.php?rt=students"><button class="login">Vrati se na prakse</button></a>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
