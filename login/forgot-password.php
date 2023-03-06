<?php

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $forgotpassword = $confirm_password = "";
$email_err = $forgotpassword_err= $confirm_password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["login_email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["login_email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["newPassword"]))){
        $forgotpassword_err = "Please enter your new password.";
    } else{
        $forgotpassword = trim($_POST["newPassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirmnewPassword"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirmnewPassword"]);
        if(empty($forgotpassword_err) && ($forgotpassword != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Validate credentials
    if(empty($email_err) && empty($forgotpassword_err)){

        $sql = "SELECT id, email, password FROM user WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $sql1 = "UPDATE user SET password = '$newPassword' WHERE email = ?";

                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s", $param_password);
                        
                        // Set parameters
                        $param_password = password_hash($forgotpassword, PASSWORD_DEFAULT); // Creates a password hash
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Redirect to login page
                            header("location: login.php");
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
            
                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                }else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }

            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
    }
    // Close connection
    mysqli_close($link);
}
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
                <h5 class="card-title my-3">Forgot Password</h5>
                <?php 
                    if(!empty($login_err)){
                        echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                    <div class="form-group">
                        <input type="text" name="login_email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Username" value="<?php echo $email; ?>" >
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="text" name="newPassword" class="form-control <?php echo (!empty($forgotpassword_err)) ? 'is-invalid' : ''; ?>" placeholder="New password">
                        <span class="invalid-feedback"><?php echo $forgotpassword_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="text" name="confirmnewPassword" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm new password">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-darkBlue w-100" value="Update">
                    </div>

                </form>
            </div>
            <div class="card-footer text-center">
                <span>Not yet registered?</span> <a href="./register.php" class="register-link">Sign up now</a>
            </div>
        </div>
    </div>
</body>
</html>