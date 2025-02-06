<?php
$title = 'Park Passport';
include 'includes/header.php';
?>


<div class="hero-image" style="height: 200px;">
    <div class="row">
        <div class="hero-text text-center">
            <h1 class="staatliches-regular">Park Passport</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php if (isset($_SESSION['authUser'])) { ?>
            <div class="d-flex row mt-4 justify-content-center">
                <div class="d-flex col-5 justify-content-end">
                    <a href="create-account.php">
                        <button type="button" class="btn btn-primary">Explore National Parks</button>
                    </a>
                </div>
                <div class="d-flex col-1 justify-content-center">
                    <div class="vertical-line"></div>
                </div>
                <div class="d-flex col-5 justify-content-start">
                    <a href="create-account.php">
                        <button type="button" class="btn btn-primary">View Your Passport</button>
                    </a>
                </div>
            </div>

        <?php } else { ?>
        <div class="row">
            <p class="lato-regular mt-4">Unlock the wonders of nature with Park Passport, your digital companion for
                exploring the beauty and majesty of national parks across the globe. Whether you're a seasoned
                outdoor enthusiast or a first-time camper, embark on unforgettable journeys and create lasting
                memories in
                some of the world's most breathtaking landscapes.
            </p>
        </div>
        <div class="row">
            <div class="d-flex justify-content-center col-12">
                <a href="create-account.php">
                    <button type="button" class="btn btn-primary">Create Your Passport</button>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex justify-content-center">
            <span>Already have an account? <a href="login.php">Login</a></span>
        </div>
    </div>
    <?php } ?>
</div>
</div>
</div>


<?php
include 'includes/footer.php';
?>
