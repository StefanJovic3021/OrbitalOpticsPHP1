<header id="header" class="alt" style="display: flex; align-items: center; justify-content: flex-end;">
    <div class="logo"><a href="index.php">Orbital Optics</a></div>
    <a href="<?= (isset($_SESSION['user'])) ? ("editAccount.php") : ("#") ?>" style="display: flex; align-items: center; justify-content: space-between;">
        <?php if(isset($_SESSION['user'])): ?>
            <div id="profileMiniPic" style="height: 40px; width: 40px; border-radius: 50%; margin-right: 10px; background-image: url('<?= stripslashes($_SESSION['user']->image_path); ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div>
        <?php else: ?>
            <i style="font-size: 40px; margin-right: 10px;" class="las la-user-circle"></i>
        <?php endif; ?>
        <p style="margin: 0px; color: #ffffff;"><?= (isset($_SESSION['user'])) ? ($_SESSION['user']->username) : ("Login") ?></p>
    </a>
    <a href="#menu">Menu</a>
</header>