</main>
<footer class="page-footer footer-color">
    <div class="container">
        <div class="row">
            <div class="col l4 s12">
                <a href="index.php" class="brand-logo white-text staatliches-regular">Park Passport</a>
            </div>
            <div class="col l4 s12">
                <h5 class="white-text staatliches-regular">Your Park Passport</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3 lato-regular" href="login.php">Login</a></li>
                    <li><a class="grey-text text-lighten-3 lato-regular" href="my-park-passport.php">My Park Passport</a></li>
                </ul>
            </div>
            <div class="col l4 s12">
                <h5 class="white-text staatliches-regular">Explore</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3 lato-regular" href="national-parks.php">National Parks</a></li>
                    <li><a class="grey-text text-lighten-3 lato-regular" href="campgrounds.php">Campgrounds</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container center-align lato-regular">
            © 2024 Park Passport
        </div>
    </div>
</footer>

<?php // close database connection (put in footer to avoid doing multiple times)
            mysqli_close($db); ?>

    <script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>