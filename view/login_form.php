<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="forma">
    <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=students/login">
        <label for="email">Email:</label>
        <input type="text" name="email" required/>
        <br/><br/>

        <label for="password">Lozinka:</label>
        <input type="password" name="password" required/>
        <br/><br/>

    	<button type="submit" class="login">Login!</button>
    </form>
</div>

<br/>
<a href="<?php echo __SITE_URL; ?>/index.php?rt=students"><button class="login">Vrati se na prakse</button></a>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
