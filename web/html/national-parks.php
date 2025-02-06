<?php
/**
 * @var mysqli $db Database Connection
 */
$title = 'National Parks';
include 'includes/header.php';
?>
    <div class="container">
        <h1 class="staatliches-regular">National Parks</h1>
        <p>Find your next adventure here. Take a look at all our beautiful national parks.</p>

        <?php
        $sortByChoice = $_GET['sort'] ?? 'parks-asc';

        if ($sortByChoice === 'parks-asc') {
            $sortBy = 'Name';
            $direction = 'ASC';
        } else if ($sortByChoice === 'parks-desc') {
            $sortBy = 'Name';
            $direction = 'DESC';
        } else if ($sortByChoice === 'state-asc') {
            $sortBy = 'State';
            $direction = 'ASC';
        } else if ($sortByChoice === 'state-desc') {
            $sortBy = 'State';
            $direction = 'DESC';
        } else {
            $sortBy = 'Name';
            $direction = 'ASC';
        }

        $query = "SELECT * FROM ParkPassport__NationalParks ORDER BY $sortBy $direction";

        // execute the query
        $result = mysqli_query($db, $query) or die('Error in query.');
        ?>
        <div class="row">

            <form method="get">
                <h6 class="staatliches-regular">Sort By: </h6>
                <button class="btn btn-secondary <?= $sortByChoice == "parks-asc" ? 'selected-sort' : '#e65100 orange darken-4' ?>"
                        type="submit" name="sort" value="parks-asc">Parks A-Z
                </button>
                <button class="btn btn-secondary <?= $sortByChoice == "parks-desc" ? 'selected-sort' : '#e65100 orange darken-4' ?>"
                        type="submit" name="sort" value="parks-desc">Parks Z-A
                </button>
                <button class="btn btn-secondary <?= $sortByChoice == "state-asc" ? 'selected-sort' : '#e65100 orange darken-4' ?>"
                        type="submit" name="sort" value="state-asc">State A-Z
                </button>
                <button class="btn btn-secondary <?= $sortByChoice == "state-desc" ? 'selected-sort' : '#e65100 orange darken-4' ?>"
                        type="submit" name="sort" value="state-desc">State Z-A
                </button>
            </form>
        </div>
        <div class="row">
            <?php
            // loop through results
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
            <div class="col-sm-12 col-md-4">
                <div class="card"
                ">
                <?php if ($row['ImageFilename'] == NULL) { ?>
                    <img class="card-img-top" src="images/placeholder.png" alt="placeholder image">
                <?php } else { ?>
                    <img class="card-img-top" src="images/uploads/parks/<?= $row['ImageFilename'] ?>"
                         alt="placeholder image">
                <?php } ?>
                <div class="card-body">
                    <span class="card-title"><?= $row['Name'] ?></span>
                    <p class="card-title state-title"><?= $row['State'] ?></p>
                    <p class="cutoff-text"><?= $row['Description'] ?></p><br>
                    <a href="national-park-info.php?id=<?= $row['NationalParkId'] ?>"
                       class="btn btn-primary">More Info</a>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>


    </div>
<?php
include 'includes/footer.php';
?>