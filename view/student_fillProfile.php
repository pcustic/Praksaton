<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<br/>
<?php
    echo htmlentities($msg, ENT_QUOTES);
?>
<br/>
<div class="profile">
    <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=students/saveProfile">
        <table class="table_profile">
            <input type="hidden" name="email" value="<?php echo $email;?>"/>
            <input type="hidden" name="name" value="<?php echo $name;?>"/>

            <tr><td>
            <label for="education">Obrazovanje:</label>
            </td><td>
            <textarea name="education" rows="5" cols="50"></textarea>
            </td></tr>

            <tr><td>
            <label for="experience">Iskustvo:</label>
            </td><td>
            <textarea name="experience" rows="5" cols="50"></textarea>
            </td></tr>

            <tr><td>
            <label for="projects">Projekti/radovi:</label>
            </td><td>
            <textarea name="projects" rows="5" cols="50"></textarea>
            </td></tr>

            <tr><td>
            <label for="prizes">Nagrade:</label>
            </td><td>
            <textarea name="prizes" rows="5" cols="50"></textarea>
            </td></tr>
        </table>
        <br/>
        <p id="error"></p>
        <button type="submit">Spremi profil!</button>
    </form>
</div>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/students_profile.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
