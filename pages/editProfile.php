<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./login/login.php");
    exit;
}
?>
<?php
include('../login/config.php');

$getTotalRecordsByUser = "SELECT * FROM user WHERE email = '$_SESSION[login_email]'";
$getTotalRecordsByUserQuery = mysqli_query($link, $getTotalRecordsByUser);
while($row = mysqli_fetch_assoc($getTotalRecordsByUserQuery)){
    $username = $row['email'];
    $plate_num = $row['plate_number'];
    $category = $row['category'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">
            <div class="profile">
                <h1 style="color: #B3B3B3;">PMS</h1>
                <h3><?php echo htmlspecialchars($_SESSION["login_email"]); ?></h3>
            </div>
            <div class="myBurger">
            <i class="fa-solid fa-bars"></i>
            </div>
            <ul class="toggleShow-items">
                <li>
                    <a href="../userIndex.php">
                        <span class="icon"><i class="fa-solid fa-gauge"></i></span>
                        <span class="item">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../userRecords.php">
                        <span class="icon"><i class="fa-solid fa-truck-moving"></i></span>
                        <span class="item">Records</span>
                    </a>
                </li>
                <li>
                    <a href="../userProfile.php" class="active">
                        <span class="icon"><i class="fa-solid fa-truck-moving"></i></span>
                        <span class="item">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="../login/logout.php">
                        <span class="icon"><i class="fa-solid fa-power-off"></i></span>
                        <span class="item">Logout</span>
                    </a>
                </li>
            </ul>

        </div>
        <div class="section">
            <div class="topbar">
                <div>
                    <a href="#" class="hamburger"><i class="fa-solid fa-bars"></i></a>
                </div>
            </div>
            <div class="content-body">
            <div class="entry-head mt-3">
                    <a href="../userProfile.php" class="btn btn-darkBlue noselect" id="goBackEntry">
                        <span class="text">Go back</span><span class="icon">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </span>
                    </a>
                </div>
                <div class="card mx-auto shadow w-50">
                    <div class="card-body">
                        
                        <div class="card">
                        <form action="../query/userTimeIn.php?method=editProfile" method="POST">
                            <div class="card-body">
                                <input type="hidden" name="user_param" value="<?php echo $_SESSION['login_email']?>">
                                <label for="edit_username">Username: </label>
                                <input type="text" class="form-control profile-inputs" name="edit_username" id="edit_username" value="<?php echo $username?>">
                                <hr>
                                <label for="edit_plateNum">Plate Number: </label>
                                <input type="text" class="form-control profile-inputs" name="edit_plateNum" id="edit_plateNum" value="<?php echo $plate_num?>">
                                <hr>
                                <label for="edit_category">Category: </label>
                                <select name="edit_category" id="edit_category" class="form-control profile-inputs">
                                    <option value="A" <?php echo $category == 'A' ? 'selected' : '' ?>>Class A</option>
                                    <option value="B" <?php echo $category == 'B' ? 'selected' : '' ?>>Class B</option>
                                    <option value="C" <?php echo $category == 'C' ? 'selected' : '' ?>>Class C</option>
                                </select>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-darkBlue profile-inputs w-100">Save Changes</button>
                                </div>
                            </div>
                        </form>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../js/action.js"></script>
</body>

</html>