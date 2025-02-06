<?php
/**
 * @var mysqli $db Database Connection
 */
$title = 'Park Passport Create Account';
include 'includes/header.php';
?>
<div class="container">
    <div class="row">
        <div class="create-account-form">
            <h5 class="center-align create-account-title staatliches-regular">Park Passport Create Account</h5>
            <?php
            $accountCreated = false;
            $firstNameIsValid = true;
            $lastNameIsValid = true;
            $usernameIsValid = true;
            $passwordIsValid = true;


            if(isset($_POST['create-account'])) {
                // get form values
                $firstName = $_POST['firstname'];
                $lastName = $_POST['lastname'];
                $username = strip_tags($_POST['username']);
                $password = $_POST['password'];

                $query = "SELECT * FROM AuthUser WHERE Username = $username";

                // validate first name
               if (empty($firstName)) {
                    $firstNameIsValid = false;
                    $firstNameError = "Must enter a first name.";
                } else if (!ctype_alpha($firstName)) {
                    $firstNameIsValid = false;
                    $firstNameError = "First name must be only letters, no numbers.";
                }

                // validate last name
                if (empty($lastName)) {
                    $lastNameIsValid = false;
                    $lastNameError = "Must enter a last name.";
                } else if (!ctype_alpha($firstName)) {
                    $lastNameIsValid = false;
                    $lastNameError2 = "Name must be only letters, no numbers.";
                }

                // validate username
                if (empty($username)){
                    $usernameIsValid = false;
                    $usernameError = "Must enter a username.";
                } else if ($result = mysqli_query($db, $query)) {
                    if (mysqli_num_rows($result) > 0) {
                        $usernameIsValid = false;
                        $usernameError = "Username is already in use. Choose a different username.";
                    }
                }

                // validate password
                if (strlen($password) <= '8'){
                    $passwordIsValid = false;
                    $passwordError = "Your Password Must Contain At Least 8 Characters!";
                }else if(!preg_match("#[0-9]+#", $password)) {
                    $passwordIsValid = false;
                    $passwordError = "Your Password Must Contain At Least 1 Number!";
                }else if(!preg_match("#[A-Z]+#", $password)) {
                    $passwordIsValid = false;
                    $passwordError = "Your Password Must Contain At Least 1 Capital Letter!";
                }else if(!preg_match("#[a-z]+#", $password)) {
                    $passwordIsValid = false;
                    $passwordError = "Your Password Must Contain At Least 1 Lowercase Letter!";
                }

                if ($firstNameIsValid && $lastNameIsValid && $usernameIsValid && $passwordIsValid) {
                    // encrypt password (after validation)
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    // add user to database
                    $query = "INSERT INTO ParkPassport__AuthUser
                            (FirstName, LastName, Username, Password, Role)
                            VALUES
                            (?, ?, ?, ?, 'user')";
                    $stmt = mysqli_prepare($db, $query);
                    mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $username, $password);
                    mysqli_stmt_execute($stmt);

                    // check if record was created
                    if ($newUserId = mysqli_stmt_insert_id($stmt)) {
                        $accountCreated = true;
                        echo '<div class="alert alert-success center-align">
                            <b>Account created!</b><br>Please login.<br>
                            <a class="btn btn-primary" href="login.php">Login</a>
                          </div>';
                    } else {
                        echo '<div class="alert alert-danger">
                          <b>Error creating account!</b><br>
                        </div>';
                    }
                }
            }
            ?>

            <?php if(!$accountCreated): ?>
            <form method="post" class="create-account-form-inputs">
                <div class="row">
                    <div class="input-field">
                        <input id="firstname" name="firstname" type="text" value="<?= $firstName ?? ''?>">
                        <label for="firstname">First Name</label>
                        <p class="alert alert-danger"><?= $firstNameError ?? ''; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="lastname" name="lastname" type="text" value="<?= $lastName ?? ''?>">
                        <label for="lastname">Last Name</label>
                        <p class="alert alert-danger"><?= $lastNameError ?? ''; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="username" name="username" type="text" value="<?= $username?? ''?>">
                        <label for="username">Username</label
                        <p class="alert alert-danger"><?= $usernameError ?? ''; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="password" name="password" type="password">
                        <label for="password">Password</label>
                        <p class="alert alert-danger"><?= $passwordError ?? ''; ?></p>
                    </div>
                </div>
                <div class="center-align">
                    <input type="submit" name="create-account" class="btn btn-primary #e65100 orange darken-4" value="Create Account">
                </div>
            </form>
            <?php endif; ?>
            <br>
            <p class="center-align"><a href="login.php">Already have an account? Login</a></p>

        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>



