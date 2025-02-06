<?php
/**
 * @var mysqli $db Database Connection
 */

$title = 'Edit Park Review';
include 'includes/header.php';

// create a CSRF token if one doesn't already exist
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? md5(uniqid());

// get review id
$id = $_GET['id'] ?? '';
$id_safe = mysqli_real_escape_string($db, $id);

// get review
$query = "SELECT * FROM ParkPassport__NationalParkReviews 
        JOIN ParkPassport__NationalParks on ParkPassport__NationalParks.NationalParkId = ParkPassport__NationalParkReviews.NationalParkId
         JOIN ParkPassport__AuthUser ON ParkPassport__AuthUser.UserId = ParkPassport__NationalParkReviews.UserId
         WHERE NationalParkReviewId = '$id_safe'";
$result = mysqli_query($db, $query) or die('Error in query.');
$review = mysqli_fetch_array($result, MYSQLI_ASSOC) or die('Review not found.');
?>

<div class="container">
    <div class="row">
        <div class="review-form">
            <h5 class="center-align review-title staatliches-regular">Edit Review for <?= $review['Name'] ?> </h5>
            <?php
            if (isset($_POST['submit'])) {

                if ($_SESSION['csrf_token'] != $_POST['csrf_token']){
                    die('Invalid token. Please try again.');
                }

                $nationalParkId = $review['NationalParkId'];
                $userId = $review['UserId'];
                $nationalParkReviewId = $_POST['nationalParkReviewId'];
                $rating = $_POST['rating'];
                $review = strip_tags($_POST['review']);

                // query to edit review
                $query = "UPDATE `ParkPassport__NationalParkReviews` 
                        SET `Rating` = ?, `Review` = ? 
                        WHERE `ParkPassport__NationalParkReviews`.`NationalParkReviewId` = ?
                        LIMIT 1";
                $stmt = mysqli_prepare($db, $query) or die('Error editing review.');
                mysqli_stmt_bind_param($stmt, 'isi', $rating, $review, $nationalParkReviewId);
                $result = mysqli_stmt_execute($stmt) or die('Error editing review.');

                // redirect back to the park page
                header('Location: national-park-info.php?id=' . $nationalParkId);
            }

            ?>
            <form method="post" class="review-form-inputs">
                <div class="row">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label>
                            <input class="with-gap" type="radio" name="rating" value="<?= $i ?>" <?= $i == $review['Rating'] ? 'checked' : ''?>>
                            <span class="orange-text"><?= implode('', array_fill(0, $i, '<i class="material-icons">star</i>')) ?><?=
                                implode('', array_fill(0, 5 - $i, '<i class="material-icons">star_border</i>')) ?></span>
                        </label><br>
                    <?php endfor; ?>
                </div>
                <div class="row">
                    <div class="input-field">
                        <textarea id="review" name="review" class="materialize-textarea"><?= $review['Review'] ?></textarea>
                        <label for="review">Review</label>
                    </div>
                </div>
                <div class="center-align">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="nationalParkReviewId" value="<?= $review['NationalParkReviewId'] ?>">
                    <input type="submit" name="submit" class="btn btn-primary #e65100 orange darken-4" value="Save Review">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
