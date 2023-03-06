<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$plate_number = $category = $reg_email = $password = $confirm_password = "";
$password_err = $confirm_password_err = "";
$plate_number_err = $category_err = $regEmail_err =  $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate plate_numer
    
    if(empty(trim($_POST["plate_number"]))){
        $plate_number_err = "Please enter your plate number.";
    }else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE plate_number = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_plate_number);
            
            // Set parameters
            $param_plate_number = trim($_POST["plate_number"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $plate_number_err = "This plate number is already taken.";
                } else{
                    $plate_number = trim($_POST["plate_number"]);
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate category
    
    if(empty(trim($_POST["category"]))){
        $category_err = "Please enter your vehicle's category.";
    }else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE category = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_category);
            
            // Set parameters
            $param_category = trim($_POST["category"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                $category = trim($_POST["category"]);

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    
    // Validate email
    if(empty(trim($_POST["reg_email"]))){
        $regEmail_err = "Please enter your email address.";
    }else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_regEmail);
            
            // Set parameters
            $param_regEmail = trim($_POST["reg_email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $regEmail_err = "This username is already taken.";
                } else{
                    $reg_email = trim($_POST["reg_email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    }else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($plate_number_err) && empty($category_err) && empty($regEmail_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (plate_number, category, email, password) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_plate_number, $param_category, $param_regEmail, $param_password);
            
            // Set parameters
            $param_plate_number = $plate_number;
            $param_category = $category;
            $$param_regEmail = $reg_email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
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
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapper">
        <div class="card shadow text-center">
            <div class="card-header">
                Parking Management System
            </div>
            <div class="card-body">
                <h5 class="card-title my-3">Registration Form</h5>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
                <!-- 
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" name="last_name" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>" placeholder="Last Name">
                        <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                    </div>
                </div> -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="reg_email" class="form-control <?php echo (!empty($regEmail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reg_email; ?>">
                        <span class="invalid-feedback"><?php echo $regEmail_err; ?></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Plate Number</label>
                        <input type="text" name="plate_number" class="form-control <?php echo (!empty($plate_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $plate_number; ?>">
                        <span class="invalid-feedback"><?php echo $plate_number_err; ?></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Vehicle's Category</label>
                        <select name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>">
                            <option hidden></option>
                            <option value="A">Class A</option>
                            <option value="B">Class B</option>
                            <option value="C">Class C</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $category_err; ?></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                </div>
            </div>   
            
            
            <div class="form-group">
                <input type="submit" class="btn btn-darkBlue w-100" value="Submit">
            </div>
        </form>
            </div>
            <div class="card-footer text-center">
        <span>Already registered?</span> <a href="./login.php" class="register-link">Login</a>
        </div>
        </div>
        
        
    </div>    
</body>
</html>