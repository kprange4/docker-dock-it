<?php
// logout and redirect to login page
if(isset($_GET['logout'])){
    // remove session data
    // (only removes username, reuses same cookie -- this is bad)
    unset($_SESSION['authUser']);

    // destroy the session (and cookie)
    session_destroy();

    // redirect
    header("Location: login.php");
    die();
}
?>

<header>
    <div class="navbar-fixed">
    <nav class="nav-extended">
        <div class="nav-content nav-content-color">
            <div class="container top-menu">
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <?php if(isset($_SESSION['authUser'])){ ?>
                    <li><a href="my-park-passport.php" class="lato-regular">My Park Passport</a></li>
                    <li class="lato-regular">
                        <form method="get">
                            <input type="submit" name="logout" class="btn btn-primary" value="Log Out">
                        </form>
                    <?php }else { ?>
                    <li><a href="login.php" class="lato-regular btn btn-primary">Login</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="nav-wrapper #ffffff white">
            <div class="container">
                <a href="index.php" class="brand-logo black-text staatliches-regular">Park Passport</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="national-parks.php" class="black-text lato-regular">National Parks</a></li>
                    <li><a href="campgrounds.php" class="black-text lato-regular">Campgrounds</a></li>
                </ul>
            </div>
        </div>
    </nav>
    </div>
</header>
