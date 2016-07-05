<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<?php echo '<p class="error">' . $errorMsg . '</p>'; ?>

<a href="<?php echo __SITE_URL; ?>"><button>Početna</button></a>
<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/loginForm"><button>Login</button></a>
<a href="<?php echo __SITE_URL; ?>/index.php?rt=students/registerForm"><button>Registracija</button></a>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
