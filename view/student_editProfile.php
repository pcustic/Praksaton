<?php
if(isset($_SESSION['name'])){
    echo '<p class="osobno">' . $_SESSION['name'] . '</p>';
?>
    <a href="<?php echo __SITE_URL; ?>/index.php?rt=students/logoutForm"><button>Log out</button></a>

<?php require_once __SITE_PATH . '/view/_header.php'; ?>

    <span class="navBar">
        <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=students/search" style='display:inline;'>
            <input type="text" name="query" id="searchText"/>
            <button type="submit" id="searchButton">Traži praksu!</button>
        </form>

        <a href="<?php echo __SITE_URL; ?>/index.php?rt=students"><button>Sve prakse!</button></a>

        <a href="<?php echo __SITE_URL; ?>/index.php?rt=students/applications"><button>Pregledaj svoje prijave!</button></a>

    </span>
    <?php
}
?>

<br/>
<div class="profile">
        <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=students/editProfile">
            <table class="table_profile">
                <input type="hidden" name="email" value="<?php echo $profile->email;?>"/>
                <input type="hidden" name="name" value="<?php echo $profile->name;?>"/>
                <tr><td>
                <label for="education">Obrazovanje:</label>
                </td><td>
                <textarea name="education" rows="5" cols="50"><?php echo $profile->education;?></textarea>
                </td></tr>

                <tr><td>
                <label for="experience">Iskustvo:</label>
                </td><td>
                <textarea name="experience" rows="5" cols="50" ><?php echo $profile->experience;?></textarea>
                </td></tr>

                <tr><td>
                <label for="projects">Projekti/radovi:</label>
                </td><td>
                <textarea name="projects" rows="5" cols="50" ><?php echo $profile->projects;?></textarea>
                </td></tr>

                <tr><td>
                <label for="prizes">Nagrade:</label>
                </td><td>
                <textarea name="prizes" rows="5" cols="50" ><?php echo $profile->prizes;?></textarea>
                </td></tr>
            </table>
            <br/>
            <p id="error"></p>
            <button type="submit" id="submit">Spremi profil!</button>
        </form>
</div>

<script type="text/javascript" src="<?php echo __SITE_URL; ?>/view/students_profile.js"></script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
