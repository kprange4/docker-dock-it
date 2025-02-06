<?php
/**
 * @var $db mysqli Database Connection
 */
$title = 'Leave a Review';
include "includes/header.php";

// create a CSRF token if one doesn't already exist
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? md5(uniqid());

// get park id
$id = $_GET['id'] ?? '';
$id_safe = mysqli_real_escape_string($db, $id);

// get park
$query = "SELECT * FROM ParkPassport__NationalParks WHERE NationalParkId = '$id_safe'";
$result = mysqli_query($db, $query) or die('Error in query.');
$park = mysqli_fetch_array($result, MYSQLI_ASSOC) or die('Park not found.');

// get username
$userId = $_SESSION['authUser']['userId'];

//get user
$query = "SELECT * FROM ParkPassport__AuthUser WHERE UserId = '$userId'";
$result = mysqli_query($db, $query) or die('Error in query.');
$user = mysqli_fetch_array($result, MYSQLI_ASSOC) or die('User not found.');

?>

<div class="container">
    <div class="row">
        <div class="review-form">
            <h5 class="center-align review-title staatliches-regular">Leave a Review for <?= $park['Name'] ?> </h5>
            <?php
            if (isset($_POST['submit'])) {

                if ($_SESSION['csrf_token'] != $_POST['csrf_token']){
                    die('Invalid token. Please try again.');
                }

                $userId = $user['UserId'];
                $nationalParkId = $id;
                $rating = $_POST['rating'];
                $review = strip_tags($_POST['review']);

                // query to add review
                $query = "INSERT INTO `ParkPassport__NationalParkReviews` 
                        (`NationalParkReviewId`, `UserId`, `NationalParkId`, `Rating`, `Review`) 
                        VALUES (NULL, ?, ?, ?, ?);";
                $stmt = mysqli_prepare($db, $query) or die('Error adding review.');
                mysqli_stmt_bind_param($stmt, 'iiis', $userId, $nationalParkId, $rating, $review);
                $result = mysqli_stmt_execute($stmt) or die('Error adding review.');

                // redirect back to the park page
                header('Location: national-park-info.php?id=' . $nationalParkId);

            }
            ?>
            <form method="post" class="review-form-inputs">
                <div class="row">
                    <input type="hidden" name="userId" id="userId" value="<?= $userId ?>">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label>
                            <input class="with-gap" type="radio" name="rating" value="<?= $i ?>">
                            <span class="orange-text"><?= implode('', array_fill(0, $i, '<i class="material-icons">star</i>')) ?><?=
                                implode('', array_fill(0, 5 - $i, '<i class="material-icons">star_border</i>')) ?></span>
                        </label><br>
                    <?php endfor; ?>
                </div>
                <div class="row">
                    <div class="input-field">
                        <textarea id="review" name="review" class="materialize-textarea"></textarea>
                        <label for="review">Review</label>
                    </div>
                </div>
                <div class="center-align">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="submit" name="submit" class="btn btn-primary #e65100 orange darken-4" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>

