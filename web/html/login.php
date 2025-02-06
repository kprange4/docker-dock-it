<?php
/**
 * @var mysqli $db Database Connection
 */


$title = 'Park Passport Login';
include 'includes/header.php';
?>
<div class="container">
    <div class="row">
        <div class="login-form">
            <h5 class="center-align login-title staatliches-regular">Park Passport Login</h5>
            <?php
            if(isset($_POST['login'])){

                if ($_SESSION['csrf_token'] != $_POST['csrf_token']){
                    die('Invalid token. Please try again.');
                }

                // get form values
                $username = $_POST['username'];
                $password = $_POST['password'];

                // get user record from database and check login
                $query = "SELECT UserId, Username, Password, Role FROM ParkPassport__AuthUser WHERE Username = ?";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);

                // bind these variables to the columns in the record (same order)
                mysqli_stmt_bind_result($stmt, $userId, $username, $hashedPassword, $role);

                // fetch the values into the variables
                mysqli_stmt_fetch($stmt);

                // check the password
                if(password_verify($password, $hashedPassword)){
                    // check if the password needs to be rehashed (updated)
                    if(password_needs_rehash($hashedPassword, PASSWORD_DEFAULT)){
                        // create a new password hash
                        $newHash = password_hash($password, PASSWORD_DEFAULT);

                        // update user record in database
                        $query = "UPDATE `ParkPassport__AuthUser`
                        SET `Password` = $newHash
                        WHERE `ParkPassport__AuthUser` . `UserId` = ?
                        LIMIT 1";
                        $stmt = mysqli_prepare($db, $query) or die('Error in query');
                        mysqli_stmt_bind_param($stmt, "i", $userId);
                        $result = mysqli_stmt_execute($stmt) or die('Error in query');
                    }
                    // update the session with the current user
                    $_SESSION['authUser']['userId'] = $userId;
                    $_SESSION['authUser']['username'] = $username;
                    $_SESSION['authUser']['role'] = $role;

                    // redirect
                    header('Location: my-park-passport.php');
                    die();
                }else{
                    $loginError = "Incorrect Username or Password, try again.";
                }
            }
            ?>
            <p class="center-align red-text"><?= $loginError ?? '' ?></p>
            <form method="post" class="login-form-inputs">
                <div class="row">
                    <div class="input-field">
                        <input id="username" name="username" type="text">
                        <label for="username">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="password" name="password" type="password">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="center-align">
                    <input type="submit" name="login" class="btn btn-primary #e65100 orange darken-4" value="Login">
                </div>
            </form>
            <br>
            <p class="center-align"><a href="create-account.php">Create an Account</a></p>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>



