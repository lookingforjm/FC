<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./login/login.php");
    exit;
}
?>
<?php
include('login/config.php');

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
    <link rel="stylesheet" href="./css/styles.css">
    <style>
        @media screen and (max-width: 800px) {
            .profile-body{
                display: grid;
                grid-template-columns: 1fr;
                font-size: 30px;
                gap: 20px;
                margin: 0;
            }
            .profile-body label {
                padding: 5px;
            }
            .card {
                margin: 0;
                height: auto;
            }
            #label1 {
                grid-row: 1 / 2;
                grid-column: 1 / 2;
            }
            #label2 {
                grid-row: 3 / 4;
                grid-column: 1 / 2;
            }
            #label3 {
                grid-row: 5 / 6;
                grid-column: 1 / 2;
            }
            #profile1{
                grid-row: 2 / 3;
                grid-column: 1 / 2;
                margin-left: 30px;
            }
            #profile2 {
                grid-row: 4 / 5;
                grid-column: 1 / 2;
                margin-left: 30px;
            }
            #profile3 {
                grid-row: 6 / 7;
                grid-column: 1 / 2;
                margin-left: 30px;
            }
        }
    </style>
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
                    <a href="./userIndex.php">
                        <span class="icon"><i class="fa-solid fa-gauge"></i></span>
                        <span class="item">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./userRecords.php">
                        <span class="icon"><i class="fa-solid fa-truck-moving"></i></span>
                        <span class="item">Records</span>
                    </a>
                </li>
                <li>
                    <a href="./userProfile.php" class="active">
                        <span class="icon"><i class="fa-solid fa-truck-moving"></i></span>
                        <span class="item">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="./login/logout.php">
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

                <div class="card mx-auto shadow">
                    <div class="card-body profile-body">
                        <label class="my-2 shadow-sm" id="label1">Username: </label><br>
                        <label class="my-2 shadow-sm" id="label2">Plate Number: </label><br>
                        <label class="my-2 shadow-sm" id="label3">Vehicle Category: </label>
                        <label class="my-2 shadow-sm" id="profile1"><?php echo $username?></label><br>
                        <label class="my-2 shadow-sm" id="profile2"><?php echo $plate_num?></label><br>
                        <label class="my-2 shadow-sm" id="profile3"><?php echo $category?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="./js/action.js"></script>
</body>

</html>