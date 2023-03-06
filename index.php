<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ./login/login.php");
    exit;
}

if($_SESSION["login_email"] != 'admin'){
    header("location: ./userIndex.php");
}

?>
<?php
    include('login/config.php');
    // gets total vehicle entered
    $getTotalEntry = "SELECT * FROM vehicle_records";
    $queryEntry = mysqli_query($link, $getTotalEntry);

    // get total vehicle currenlty parked
    $currentParking = "SELECT * FROM vehicle_records WHERE date_exit IS NULL";
    $queryCarParked = mysqli_query($link, $currentParking);

    // get total vehicle exited
    $carExited = "SELECT * FROM vehicle_records WHERE date_exit != 'NULL'";
    $queryCarExit = mysqli_query($link, $carExited);

    $totalSpaces = "SELECT * FROM parking_space";
    $queryTotalSpaces = mysqli_query($link, $totalSpaces);
    while($row = mysqli_fetch_assoc($queryTotalSpaces)){
        $spaces = $row['spaces'];
        $availableSpace = $row['available_space'];
    }
    
    $vehicleEntry = "SELECT * FROM vehicle_records WHERE date_exit IS NULL";
    $queryVehicleEntry = mysqli_query($link, $vehicleEntry);
    if ($queryVehicleEntry)
    {
        // it return number of rows in the table.
        $countParked = mysqli_num_rows($queryVehicleEntry);
        // close the result.
        mysqli_free_result($queryVehicleEntry);
    }

    $getTotalSpaces = "SELECT * FROM parking_space";
    $getTotalSpacesQuery = mysqli_query($link, $getTotalSpaces);
    while($getTotalSpacesRow = mysqli_fetch_assoc($getTotalSpacesQuery)){
        $totalClassA = $getTotalSpacesRow['classA'];
        $totalClassB = $getTotalSpacesRow['classB'];
        $totalClassC = $getTotalSpacesRow['classC'];
    }
    $totalSpaceAll = $totalClassA + $totalClassB + $totalClassC;
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
                    <a href="./" class="active">
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
                <div class="col-md-4 col-sm-12">
                <div class="card col-4 shadow">
                    <div class="card-header text-center bg-darkBlue">
                        Total Vehicles Entered
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo mysqli_num_rows($queryEntry)  ?></h5>
                    </div>
                </div>
                </div>
                <div class="col-md-4 col-sm-12">
                <div class="card col-4 shadow">
                    <div class="card-header text-center bg-darkBlue">
                        Vehicles currently parked
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo mysqli_num_rows($queryCarParked)  ?></h5>
                    </div>
                </div>
                </div>
                <div class="col-md-4 col-sm-12">
                <div class="card col-4 shadow">
                    <div class="card-header text-center bg-darkBlue">
                        Total Vehicles Exited
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo mysqli_num_rows($queryCarExit)  ?></h5>
                    </div>
                </div>
                </div>
                <div class="col-md-6 col-sm-12 mx-auto">
                <div class="card shadow">
                    <div class="card-header text-center bg-darkBlue">
                        Total Parking Spaces Available
                    </div>
                    <div class="card-body text-center">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                </div>
                
            </div>
            
        </div>
        </div>
    </div>


    <?php

        $dataPoints = array( 
            array("label"=>"Available Spaces", "y"=> $totalSpaceAll - $countParked ),
            array("label"=>"Occupied", "y"=> $countParked)
        )
        
    ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                theme: "light2",
                animationEnabled: true,
                data: [{
                    type: "pie",
                    indexLabel: "{y}",
                    yValueFormatString: "#,##0\"\"",
                    indexLabel: "{label} ({y})",
		            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
            }
    </script>
    <script src="./js/canvasjs.min.js"></script>
    <script src="./js/action.js"></script>
</body>
</html>