<?php
$title = 'Campground Name';
include 'includes/header.php';
?>

<div class="row">
    <div class="container">
        <div class="col-6">
            <h3 class="staatliches-regular">Campground Name</h3>
            <h5 class="staatliches-regular">Address</h5>
            <p class="lato-regular">Description</p>
        </div>
        <div class="col-6">
            <img>
        </div>
    </div>
</div>

<div class="row">
    <div class="container">
        <h4 class="staatliches-regular">Site Types</h4>
    </div>
</div>

<div class="row campground-review-section">
    <div class="container">
        <div class="add-review">
            <h4 class="staatliches-regular white-text" style="width: fit-content">Reviews</h4>
            <a href="add-review.php" class="btn btn-primary #e65100 orange darken-4">Leave a Review</a>
        </div>
        <table class="highlight campground-review-table">
            <thead>
            <tr>
                <th>Rating</th>
                <th>Review</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Rating</td>
                <td>Review</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?php
include 'includes/footer.php';
?>
