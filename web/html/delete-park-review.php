<?php
/**
 * @var mysqli $db Database Connection
 */

$title = 'Delete a Review';
include 'includes/header.php';

// create a CSRF token if one doesn't already exist
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? md5(uniqid());

// get park id
$id = $_GET['id'] ?? '';
$id_safe = mysqli_real_escape_string($db, $id);

// get park
$query = "SELECT * FROM ParkPassport__NationalParkReviews 
         JOIN ParkPassport__AuthUser ON ParkPassport__AuthUser.UserId = ParkPassport__NationalParkReviews.UserId
         WHERE NationalParkReviewId = '$id_safe'";
$result = mysqli_query($db, $query) or die('Error in query.');
$review = mysqli_fetch_array($result, MYSQLI_ASSOC) or die('Park not found.');
?>

<div class="container">
    <h4>Delete Place</h4>
    <?php
    if (isset($_POST['submit'])){

        if ($_SESSION['csrf_token'] != $_POST['csrf_token']){
            die('Invalid token. Please try again.');
        }

        $nationalParkId = $_POST['nationalParkId'];
        $nationalParkReviewId = $_POST['nationalParkReviewId'];

        // query to add place
        $query = "DELETE FROM `ParkPassport__NationalParkReviews`
            WHERE `ParkPassport__NationalParkReviews`.`NationalParkReviewId` = ?
            LIMIT 1";
        $stmt = mysqli_prepare($db, $query) or die('Error deleting review.');
        mysqli_stmt_bind_param($stmt, 'i', $nationalParkReviewId);
        $result = mysqli_stmt_execute($stmt) or die('Error deleting review.');

        // redirect back to the city page
        header('Location: national-park-info.php?id='. $nationalParkId);

    }
    ?>
        <p>
            Are you sure you want to delete your review?
        </p>
        <table class="park-review-table">
            <tbody>
                <tr>
                    <td><?= $review['Username'] ?></td>
                    <td><?= implode('', array_fill(0, $review['Rating'], '<i class="material-icons">star</i>')) ?><?=
                        implode('', array_fill(0, 5 - $review['Rating'], '<i class="material-icons">star_border</i>')) ?></td>
                    <td><?= $review['Review'] ?></td>
                </tr>
            </tbody>
        </table>
    <br>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="nationalParkId" value="<?= $review['NationalParkId'] ?>">
        <input type="hidden" name="nationalParkReviewId" value="<?= $review['NationalParkReviewId'] ?>">
        <button type="submit" class="btn btn-secondary #b71c1c red darken-4" name="submit">Delete Review</button>
        <a class="btn btn-secondary #e65100 orange darken-4" href="national-park-info.php?id=<?= $review['NationalParkId']?>">Cancel</a>
    </form>
    <br>
</div>

<?php
include 'includes/footer.php';
?>

