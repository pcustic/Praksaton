<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="forma">
    <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=companies/login">
        <label for="email">Email:</label>
        <input type="text" name="email"/>
        <br/><br/>

        <label for="password">Lozinka:</label>
        <input type="password" name="password"/>
        <br/><br/>
        <p id="error"></p>
    	<button type="submit" id="submit">Login</button>
    </form>
</div>


<br/>
<div id="registration">
    <p>Još se niste registrirali?</p>
    <a href="<?php echo __SITE_URL; ?>/index.php?rt=companies/registerForm"><button>Registrirajte se</button></a>
</div>

<br/><br/>

<a href="<?php echo __SITE_URL; ?>"><button>Početna</button></a>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/companies_login.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
