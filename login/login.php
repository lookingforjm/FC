<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION['login_email'] == 'admin') {
        header("location: .././");
        exit;
    } else {
        header("location: ../userIndex.php");
        exit;
    }
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["login_email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["login_email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password, isAdmin FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $isAdmin);
                    if (mysqli_stmt_fetch($stmt)) {

                        if ($email == 'admin') {
                            if (password_verify($password, $hashed_password)) {
                                // Password is correct, so start a new session
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["login_email"] = $email;
                                $_SESSION["isAdmin"] = true;

                                // Redirect user to welcome page
                                header("location: .././");
                            } else {
                                // Password is not valid, display a generic error message
                                $login_err = "Invalid username or password.";
                            }
                        } else {
                            if (password_verify($password, $hashed_password)) {
                                // Password is correct, so start a new session
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["login_email"] = $email;
                                $_SESSION["isAdmin"] = true;

                                // Redirect user to welcome page
                                header("location: ../userIndex.php");
                            } else {
                                // Password is not valid, display a generic error message
                                $login_err = "Invalid username or password.";
                            }
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="wrapper">
                <div class="card">
                    <div class="card-header text-center">
                        Parking Management System
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title my-3">Login Form</h5>
                        <?php
                        if (!empty($login_err)) {
                            echo '<div class="alert alert-danger">' . $login_err . '</div>';
                        }
                        ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                            <div class="form-group">
                                <input type="text" name="login_email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Username">
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password">
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-darkBlue w-100" value="Login">
                            </div>
                            <a href="./forgot-password.php" class="register-link">Forgot Password?</a>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <span>Not yet registered?</span> <a href="./register.php" class="register-link">Sign up now</a>
                    </div>
                </div>

    </div>
</body>

</html>