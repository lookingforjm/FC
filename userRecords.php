<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./login/login.php");
    exit;
}
?>
<?php
    include('login/config.php');

    $getTotalRecordsByUser = "SELECT * FROM vehicle_records WHERE username = '$_SESSION[login_email]'";
    $getTotalRecordsByUserQuery = mysqli_query($link, $getTotalRecordsByUser);

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
        @media screen and (max-width: 1000px) {
            .content-body {
                overflow-x: scroll;
                padding: 0;
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
                    <a href="./userRecords.php" class="active">
                        <span class="icon"><i class="fa-solid fa-truck-moving"></i></span>
                        <span class="item">Records</span>
                    </a>
                </li>
                <li>
                    <a href="./userProfile.php">
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
                        <table class="table table-bordered table-hover table-striped table-condensed">
                            <thead class="bg-lightBlue">
                                <tr>
                                    <th width="20%">Username</th>
                                    <th width="20%">Plate Number</th>
                                    <th width="20%">Date Entry</th>
                                    <th width="20%">Date Exit</th>
                                    <th width="20%">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row = mysqli_fetch_assoc($getTotalRecordsByUserQuery)){
                                        echo"
                                        <tr>
                                            <td>$row[username]</td>
                                            <td>$row[plate_num]</td>
                                            <td>$row[date_entry]</td>
                                            <td>$row[date_exit]</td>
                                            <td>$row[category]</td>
                                        </tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="./js/action.js"></script>
</body>

</html>