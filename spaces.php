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

// Class A
$classAEntry = "SELECT * FROM vehicle_records WHERE category = 'A' AND date_exit IS NULL";
$queryclassAEntry = mysqli_query($link, $classAEntry);
$cnt_classA = mysqli_num_rows($queryclassAEntry);

$classA = "SELECT * FROM parking_space";
$queryclassA = mysqli_query($link, $classA);
while ($row = mysqli_fetch_assoc($queryclassA)) {
    $classAValue = $row['classA'];
}

$availableASpace = $classAValue - $cnt_classA;

// Class B
$classBEntry = "SELECT * FROM vehicle_records WHERE category = 'B' AND date_exit IS NULL";
$queryclassBEntry = mysqli_query($link, $classBEntry);
$cnt_classB = mysqli_num_rows($queryclassBEntry);

$classB = "SELECT * FROM parking_space";
$queryclassB = mysqli_query($link, $classB);
while ($row = mysqli_fetch_assoc($queryclassB)) {
    $classBValue = $row['classB'];
}

$availableBSpace = $classBValue - $cnt_classB;

// Class C
$classCEntry = "SELECT * FROM vehicle_records WHERE category = 'C' AND date_exit IS NULL";
$queryclassCEntry = mysqli_query($link, $classCEntry);
$cnt_classC = mysqli_num_rows($queryclassCEntry);

$classC = "SELECT * FROM parking_space";
$queryclassC = mysqli_query($link, $classC);
while ($row = mysqli_fetch_assoc($queryclassC)) {
    $classCValue = $row['classC'];
}

$availableCSpace = $classCValue - $cnt_classC;

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
                    <a href="./category.php">
                        <span class="icon"><i class="fa-solid fa-list-ul"></i></span>
                        <span class="item">Category</span>
                    </a>
                </li>
                <li>
                    <a href="./spaces.php" class="active">
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
                <div class="spaces-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card text-center">
                                <div class="card-header bg-darkBlue">
                                    <h2>Total Class A Spaces</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-condensed table-striped table-hover">
                                        <thead class="bg-lightBlue text-center">
                                            <tr>
                                                <th width="50%">Available</th>
                                                <th width="50%">Total Space</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $availableASpace ?></td>
                                                <td><?php echo $classAValue ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <a href="./pages/spaceClassA.php" class="btn btn-darkBlue">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card text-center">
                                <div class="card-header bg-darkBlue">
                                    <h2>Total Class B Spaces</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-condensed table-striped table-hover">
                                        <thead class="bg-lightBlue text-center">
                                            <tr>
                                                <th width="50%">Available</th>
                                                <th width="50%">Total Space</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $availableBSpace ?></td>
                                                <td><?php echo $classBValue ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <a href="./pages/spaceClassB.php" class="btn btn-darkBlue">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card text-center">
                                <div class="card-header bg-darkBlue">
                                    <h2>Total Class C Spaces</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-condensed table-striped table-hover">
                                        <thead class="bg-lightBlue text-center">
                                            <tr>
                                                <th width="50%">Available</th>
                                                <th width="50%">Total Space</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $availableCSpace ?></td>
                                                <td><?php echo $classCValue ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                        <a href="./pages/spaceClassC.php" class="btn btn-darkBlue">Manage</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <script src="./js/action.js"></script>
</body>

</html>