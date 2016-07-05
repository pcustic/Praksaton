<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div class="forma">
    <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=companies/register">
        <table class="registration">
            <tr><td>
        	<label for="name">Naziv:</label>
            </td><td>
            <input type="text" name="name"/>
            </td></tr>

            <tr><td>
            <label for="email">Email:</label>
            </td><td>
            <input type="text" name="email"/>
            </td></tr>

            <tr><td>
            <label for="password">Lozinka:</label>
            </td><td>
            <input type="password" name="password"/>
            </td></tr>

            <tr><td>
            <label for="description">O nama:</label>
            </td><td>
            <textarea name="description" cols="50" rows="5"></textarea>
            </td></tr>
        </table>
        <br/>
        <p id="error"></p>
    	<button type="submit">Registrirajte se</button>
    </form>
</div>

<br/><br/>
<a href="<?php echo __SITE_URL; ?>"><button>Početna</button></a>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/companies_register.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
