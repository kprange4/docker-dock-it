<?php
/**
 * @var mysqli $db Database Connection
 */
$title = 'My Park Passport';
include 'includes/header.php';

// get username
$userId = $_SESSION['authUser']['userId'];

?>

<div class="container">
    <h1 class="staatliches-regular">My Park Passport</h1>

    <div class="row">
        <h4 class="staatliches-regular">My Parks</h4>
        <?php
            $query = "SELECT * FROM ParkPassport__UserParks 
                JOIN ParkPassport__NationalParks ON ParkPassport__NationalParks.NationalParkId = ParkPassport__UserParks.NationalParkId
                WHERE UserId = $userId";
            $result = mysqli_query($db, $query) or die("Error loading reviews.");
        ?>
        <?php
        // loop through results
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
            <div class="col s12 m4">
                <div class="card align-items-stretch">
                    <div class="card-image">
                        <?php if ($row['ImageFilename'] == NULL) { ?>
                            <img src="images/placeholder.png" alt="placeholder image">
                        <?php } else { ?>
                            <img src="images/uploads/parks/<?= $row['ImageFilename'] ?>" alt="placeholder image">
                        <?php } ?>
                    </div>
                    <div class="card-content">
                        <span class="card-title"><?= $row['Name'] ?></span>
                        <p class="card-title state-title"><?= $row['State'] ?></p>
                        <p class="cutoff-text"><?= $row['Description'] ?></p><br>
                        <a href="national-park-info.php?id=<?= $row['NationalParkId'] ?>" class="btn btn-primary #e65100 orange darken-4">More Info</a>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>


    <?php
    // query to get reviews
    $query = "SELECT * FROM ParkPassport__NationalParkReviews
         JOIN ParkPassport__AuthUser ON ParkPassport__AuthUser.UserId = ParkPassport__NationalParkReviews.UserId
         JOIN ParkPassport__NationalParks ON ParkPassport__NationalParks.NationalParkId = ParkPassport__NationalParkReviews.NationalParkId
         WHERE `ParkPassport__NationalParkReviews` . `UserId` = '$userId'";

    // execute query
    $result = mysqli_query($db, $query) or die("Error loading reviews.");
    ?>
    <div class="row">
    <h4 class="staatliches-regular">My Reviews</h4>
    <?php // if rows are returned, display table
    if (mysqli_num_rows($result)): ?>
        <table class="highlight park-review-table">
            <thead>
            <tr>
                <th>User</th>
                <th>National Park</th>
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
                    <td><a href="national-park-info.php?id=<?= $row['NationalParkId'] ?>"><?= $row['Name'] ?></a></td>
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
    <?php elseif (!mysqli_num_rows($result)): ?>
        <p>You don't have any reviews yet.</p>
    <?php endif; ?>
    </div>


</div>





<?php
include 'includes/footer.php';
?>
