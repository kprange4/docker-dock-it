<?php
/**
 * @var mysqli $db Database Connection
 */

$title = 'Edit National Park';
include 'includes/header.php';

// create a CSRF token if one doesn't already exist
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? md5(uniqid());

// get park id
$id = $_GET['id'] ?? '';
$id_safe = mysqli_real_escape_string($db, $id);

// get park
$query = "SELECT * FROM ParkPassport__NationalParks WHERE NationalParkId = '$id_safe'";
$result = mysqli_query($db, $query) or die('Error in query.');
$park = mysqli_fetch_array($result, MYSQLI_ASSOC) or die('Park not found.');


?>

    <div class="container">
        <div class="row">
            <div class="park-form">
                <h5 class="center-align park-title staatliches-regular">Edit <?= $park['Name'] ?> </h5>
                <?php
                if (isset($_POST['submit'])) {

                    if ($_SESSION['csrf_token'] != $_POST['csrf_token']){
                        die('Invalid token. Please try again.');
                    }

                    $nationalParkId = $park['NationalParkId'];
                    $description = $_POST['park-description'];

                    // query to edit park description
                    $query = "UPDATE `ParkPassport__NationalParks` 
                        SET `Description` = ?
                        WHERE `ParkPassport__NationalParks`.`NationalParkId` = ?
                        LIMIT 1";
                    $stmt = mysqli_prepare($db, $query) or die('Error adding visited park.');
                    mysqli_stmt_bind_param($stmt, 'si', $description, $nationalParkId);
                    $result = mysqli_stmt_execute($stmt) or die('Error adding visited park.');

                    // get uploaded image
                    $image = $_FILES['image'] ?? false;
                    $maxImageSize = 2 * 1024 * 1024; // 2MB
                    $imageSize = $_FILES['image']['size'];


                    if ($image && $image['name']) {
                        $imageFilename = time() . '-' . basename($image['name']);
                        $imageExt = pathinfo($imageFilename, PATHINFO_EXTENSION);

                        if (in_array($imageExt, ['jpg', 'jpeg', 'gif', 'png'])) {
                            if ($imageSize > $maxImageSize) {
                                echo "File size exceeds the maximum limit of 2MB.";
                                die('File size too big.');
                            }

                            //move the file
                            $uploadsDir = 'images/uploads/parks/';
                            if (move_uploaded_file($image['tmp_name'], $uploadsDir . $imageFilename)) {

                                // query to edit park image
                                $query = "UPDATE `ParkPassport__NationalParks` 
                                    SET `ImageFilename` = ?
                                    WHERE `ParkPassport__NationalParks`.`NationalParkId` = ?
                                    LIMIT 1";
                                $stmt = mysqli_prepare($db, $query) or die('Error adding image.');
                                mysqli_stmt_bind_param($stmt, 'si', $imageFilename, $nationalParkId);
                                $result = mysqli_stmt_execute($stmt) or die('Error adding image.');
                            } else {
                                die('Failed to move file');
                            }
                        } else {
                            $imageError = "Image must be a .jpg, .gif, or .png.";
                            die('Invalid file type.');
                        }
                    }
                    // check if we need to remove an image
                    if (isset($_POST['removeImage'])) {
                        // delete the file
                        unlink('images/uploads/parks/' . $imageFilename);

                        // update the database
                        $query = "UPDATE `ParkPassport__NationalParks` 
                        SET `ImageFilename` = NULL
                        WHERE `ParkPassport__NationalParks`.`NationalParkId` = ?
                        LIMIT 1";
                        $stmt = mysqli_prepare($db, $query) or die('Error adding image.');
                        mysqli_stmt_bind_param($stmt, 'i',  $nationalParkId);
                        $result = mysqli_stmt_execute($stmt) or die('Error adding image.');

                    }

                    header('Location: national-park-info.php?id=' . $nationalParkId);
                }

                ?>
                <form method="post" class="park-form-inputs" enctype="multipart/form-data">
                    <div class="row">
                        <div class="input-field">
                        <textarea id="park-description" name="park-description"
                                  class="materialize-textarea"><?= $park['Description'] ?></textarea>
                            <label for="park-description">Description</label>
                        </div>
                    </div>
                    <div class="row">
                        <?php if (isset($park['ImageFilename'])) { ?>
                            <label for="removeImage">
                                <input type="checkbox" class="filled-in" name="removeImage" id="removeImage" value="1">
                                <span>Remove Image (<?= $park['ImageFilename'] ?>)</span>
                            </label>
                        <?php } else { ?>
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Image</span><span><?= $imageError ?? '' ?></span>
                                    <input type="file" name="image" id="image">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder=".jpg, .png, .gif">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="center-align">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="nationalParkId" value="<?= $park['NationalParkId'] ?>">
                        <input type="submit" name="submit" class="btn btn-primary #e65100 orange darken-4"
                               value="Save Park">
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
include 'includes/footer.php';
?>