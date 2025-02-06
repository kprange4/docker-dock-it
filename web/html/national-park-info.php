<?php
/**
 * @var mysqli $db Database Connection
 */

$title = 'National Park Info';
include 'includes/header.php';

// get user id
$userId = $_SESSION['authUser']['userId'] ?? '';

// get park id
$id = $_GET['id'] ?? '';
$id_safe = mysqli_real_escape_string($db, $id);

// get park
$query = "SELECT * FROM ParkPassport__NationalParks WHERE NationalParkId = '$id_safe'";
$result = mysqli_query($db, $query) or die('Error in query.');
$park = mysqli_fetch_array($result, MYSQLI_ASSOC) or die('Park not found.');

?>

<div class="row">
    <br>
    <div class="container">
        <div class="col s6">
            <h3 class="staatliches-regular"><?= $park['Name'] ?></h3>
            <h5 class="staatliches-regular"><?= $park['State'] ?></h5>
            <p class="lato-regular"><?= $park['Description'] ?></p>
            <?php
            if (isset($_POST['submit'])) {
                $nationalParkId = $_POST['nationalParkId'];
                $userId = $_POST['userId'];

                // query to add visited park
                $query = "INSERT INTO `ParkPassport__UserParks` (`UserId`, `NationalParkId`) VALUES (?, ?)";
                $stmt = mysqli_prepare($db, $query) or die('Error adding visited park.');
                mysqli_stmt_bind_param($stmt, 'ii', $userId, $nationalParkId);
                $result = mysqli_stmt_execute($stmt) or die('Error adding visited park.');
            }
            ?>
            <form method="post">
                <input type="hidden" name="userId" id="userId" value="<?= $userId ?>">
                <input type="hidden" name="nationalParkId" id="nationalParkId" value="<?= $park['NationalParkId'] ?>">
                <input type="submit" name="submit" class="btn btn-secondary #e65100 orange darken-4" value="I have visited this park">
            </form>
            <?php if (isset($_SESSION['authUser']) && $_SESSION['authUser']['role'] == 'admin'): ?>
            <br>
                <a href="edit-park.php?id=<?= $park['NationalParkId'] ?>" class="btn btn-primary #e65100 orange darken-4">Edit</a>
            <?php endif; ?>
            <h4 class="staatliches-regular">Activities</h4>

        </div>
        <div class="col s6">
            <?php if ($park['ImageFilename'] == NULL) { ?>
                <img src="images/placeholder.png" alt="placeholder image" width="500px">
            <?php } else { ?>
                <img src="images/uploads/parks/<?= $park['ImageFilename'] ?>" alt="placeholder image" class="park-image">
            <?php } ?>
        </div>
    </div>
</div>

<?php
// query to get reviews
$query = "SELECT * FROM ParkPassport__NationalParkReviews
         JOIN ParkPassport__AuthUser ON ParkPassport__AuthUser.UserId = ParkPassport__NationalParkReviews.UserId
         WHERE NationalParkId = '$id_safe'";

// execute query
$result = mysqli_query($db, $query) or die("Error loading places.");
?>
<div class="row park-review-section">
    <div class="container">
        <div class="add-review">
            <h4 class="staatliches-regular" style="width: fit-content">Reviews</h4>
            <a href="add-review.php?id=<?= $park['NationalParkId'] ?>" class="btn btn-primary #e65100 orange darken-4">Leave
                a Review</a>
        </div>
        <?php // if rows are returned, display table
        if (mysqli_num_rows($result)): ?>
        <table class="highlight park-review-table">
            <thead>
            <tr>
                <th>User</th>
                <th>Rating</th>
                <th>Review</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                <tr>
                    <td><?= $row['Username'] ?></td>
                    <td><?= implode('', array_fill(0, $row['Rating'], '<i class="material-icons">star</i>')) ?><?=
                        implode('', array_fill(0, 5 - $row['Rating'], '<i class="material-icons">star_border</i>')) ?></td>
                    <td><?= $row['Review'] ?></td>
                    <?php if (isset($_SESSION['authUser']) && $_SESSION['authUser']['username'] == $row['Username']) { ?>
                    <td>
                        <a href="edit-park-review.php?id=<?= $row['NationalParkReviewId'] ?>" class="btn btn-secondary #e65100 orange darken-4">Edit</a>
                        <a href="delete-park-review.php?id=<?= $row['NationalParkReviewId'] ?>" class="btn btn-secondary #b71c1c red darken-4">Delete</a>
                    </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<div class="row campground-section">
    <div class="container">
        <div class="add-campground">
            <h4 class="staatliches-regular">Campgrounds</h4>
            <?php if (isset($_SESSION['authUser']) && $_SESSION['authUser']['role'] == 'admin'): ?>
                <a href="add-campground.php" class="btn btn-primary #e65100 orange darken-4">Add a Campground</a>
            <?php endif; ?>
        </div>
        <p>Thinking about taking a trip to <?= $park['Name'] ?>? Find a campground to stay at here!</p>
        <table class="highlight park-review-table">
            <thead>
            <tr>
                <th>Campground</th>
                <th>Description</th>
                <th>Rating</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Campground</td>
                <td>Description</td>
                <td>Rating</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'includes/footer.php';
?>

