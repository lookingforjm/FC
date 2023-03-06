<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./login/login.php");
    exit;
}

if ($_SESSION["login_email"] != 'admin') {
    header("location: ./userIndex.php");
}

?>
<?php

include('login/config.php');
// Class A entry
$classAEntry = "SELECT * FROM vehicle_records WHERE category = 'A' AND date_exit IS NULL";
$queryClassAEntry = mysqli_query($link, $classAEntry);
// Class B entry
$classBEntry = "SELECT * FROM vehicle_records WHERE category = 'B' AND date_exit IS NULL";
$queryClassBEntry = mysqli_query($link, $classBEntry);
// Class C entry
$classCEntry = "SELECT * FROM vehicle_records WHERE category = 'C' AND date_exit IS NULL";
$queryClassCEntry = mysqli_query($link, $classCEntry);

// Class A exit
$classAExit = "SELECT * FROM vehicle_records WHERE category = 'A' AND date_exit != 'NULL'";
$queryClassAExit = mysqli_query($link, $classAExit);
// Class B exit
$classBExit = "SELECT * FROM vehicle_records WHERE category = 'B' AND date_exit != 'NULL'";
$queryClassBExit = mysqli_query($link, $classBExit);
// Class C exit
$classCExit = "SELECT * FROM vehicle_records WHERE category = 'C' AND date_exit != 'NULL'";
$queryClassCExit = mysqli_query($link, $classCExit);


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
                    <a href="./">
                        <span class="icon"><i class="fa-solid fa-gauge"></i></span>
                        <span class="item">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./vehicleEntry.php">
                        <span class="icon"><i class="fa-solid fa-truck-moving"></i></span>
                        <span class="item">Vehicle Entry</span>
                    </a>
                </li>
                <li>
                    <a href="./vehicleExit.php">
                        <span class="icon"><i class="fa-solid fa-truck-moving icon-exit"></i></span>
                        <span class="item">Vehicle Exit</span>
                    </a>
                </li>
                <li>
                    <a href="./category.php" class="active">
                        <span class="icon"><i class="fa-solid fa-list-ul"></i></span>
                        <span class="item">Category</span>
                    </a>
                </li>
                <li>
                    <a href="./spaces.php">
                        <span class="icon"><i class="fa-solid fa-database"></i></span>
                        <span class="item">Spaces</span>
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
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-darkBlue text-center">
                                <h2>Class A</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <thead class="bg-lightBlue">
                                        <tr>
                                            <th width="50%">Entry</th>
                                            <th width="50%">Exit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="50%" class="category-text"><?php echo mysqli_num_rows($queryClassAEntry)  ?></td>
                                            <td width="50%" class="category-text"><?php echo mysqli_num_rows($queryClassAExit)  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-center">
                                <a class="btn btn-lightBlue" href="./pages/classA.php">View more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-darkBlue text-center">
                                <h2>Class B</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <thead class="bg-lightBlue">
                                        <tr>
                                            <th width="50%">Entry</th>
                                            <th width="50%">Exit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="50%" class="category-text"><?php echo mysqli_num_rows($queryClassBEntry)  ?></td>
                                            <td width="50%" class="category-text"><?php echo mysqli_num_rows($queryClassBExit)  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-center">
                                <a class="btn btn-lightBlue" href="./pages/classB.php">View more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-darkBlue text-center">
                                <h2>Class C</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <thead class="bg-lightBlue">
                                        <tr>
                                            <th width="50%">Entry</th>
                                            <th width="50%">Exit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="50%" class="category-text"><?php echo mysqli_num_rows($queryClassCEntry)  ?></td>
                                            <td width="50%" class="category-text"><?php echo mysqli_num_rows($queryClassCExit)  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-center">
                                <a class="btn btn-lightBlue" href="./pages/classC.php">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/action.js"></script>
</body>

</html>