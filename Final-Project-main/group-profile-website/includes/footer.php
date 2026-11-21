<?php
// includes/footer.php
// Shared bottom of every page. Closes <body> and <html>.
$group = [
    "name"    => "Group Profile Project",
    "logo"    => "img/logo1.jpg",
];
?>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-inner">
                <div class="footer-brand">
                    <img src="<?= e($group['logo']) ?>" alt="">
                    <span><?= e($group['name']) ?></span>
                </div>

                <nav class="footer-nav" aria-label="Footer navigation">
                    <a href="index.php#about">About Us</a>
                    <a href="index.php#team">Meet the Team</a>
                    <a href="index.php#data">Data</a>
                    <a href="contact.php">Contact Us</a>
                </nav>
            </div>

            <p class="footer-copy">&copy; <?= date("Y") ?> <?= e($group['name']) ?> - Final Project</p>
        </div>
    </footer>

    <script src="js/nav.js"></script>

</body>

</html>
