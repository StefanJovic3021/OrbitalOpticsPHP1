<nav id="menu">
    <ul class="links">
        <li><a href="index.php">Home</a></li>
        <li><a href="productsPage.php">Products</a></li>
        <li><a href="aboutPage.php">About us | Contact</a></li>
        <?php if(!isset($_SESSION['user'])): ?>
            <li><a href="loginPage.php">Log in | Register</a></li>
        <?php endif; ?>
        <li><a href="cartPage.php">Cart</a></li>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']->role == 'admin'): ?>
            <li><a href="adminPage.php">= ADMIN PANEL =</a></li>
        <?php endif; ?>
        <?php if(isset($_SESSION['user'])): ?>
            <li><a href="php/logout.php">Log out</a></li>
        <?php endif; ?>
    </ul>
</nav>