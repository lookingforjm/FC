<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login/login.php");
    exit;
}

if ($_SESSION["login_email"] != 'admin') {
    header("location: ../userIndex.php");
}

?>
<?php

include('../login/config.php');

// Class A
$classB = "SELECT * FROM parking_space";
$queryclassB = mysqli_query($link, $classB);
while ($row = mysqli_fetch_assoc($queryclassB)) {
    $classBValue = $row['classB'];
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
                    <a href=".././">
                        <span class="icon"><i class="fa-solid fa-gauge"></i></span>
                        <span class="item">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../vehicleEntry.php">
                        <span class="icon"><i class="fa-solid fa-truck-moving"></i></span>
                        <span class="item">Vehicle Entry</span>
                    </a>
                </li>
                <li>
                    <a href="../vehicleExit.php">
                        <span class="icon"><i class="fa-solid fa-truck-moving icon-exit"></i></span>
                        <span class="item">Vehicle Exit</span>
                    </a>
                </li>
                <li>
                    <a href="../category.php">
                        <span class="icon"><i class="fa-solid fa-list-ul"></i></span>
                        <span class="item">Category</span>
                    </a>
                </li>
                <li>
                    <a href="../spaces.php" class="active">
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
                <div class="spaceA-head mt-3">
                    <a href="../spaces.php" class="btn btn-darkBlue noselect" id="goBackEntry">
                        <span class="text">Go back</span><span class="icon">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </span>
                    </a>
                </div>
                <div class="spaceA-body">
                <div class="col-lg-4 col-md-4 col-sm-12  mx-auto">
                    <div class="card text-center">
                        <div class="card-header bg-darkBlue">
                            Update Total Spaces for "Class B" vehicles
                        </div>
                        <div class="card-body">
                            <form action="../query/spaceQuery.php?method=classB" method="POST">
                                <div class="row">
                                    <div class="col-12 my-2">
                                        <input type="text" name="totalClassB" class="form-control space-value" value="<?php echo $classBValue ?>">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-darkBlue w-100">Update count</button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
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