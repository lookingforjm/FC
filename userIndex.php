<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./login/login.php");
    exit;
}

?>
<?php
date_default_timezone_set("Asia/manila");
$dateToday = date("d/m/Y h:i a");
$dateParam = date("d/m/Y");


include('login/config.php');

// get the value of user based on the registered username
$userRecords = "SELECT * FROM user WHERE email = '$_SESSION[login_email]'";
$userRecordsQuery = mysqli_query($link, $userRecords);
while ($userRecordsRow = mysqli_fetch_assoc($userRecordsQuery)) {
    $userUsername = $userRecordsRow['email'];
    $userPlateNum = $userRecordsRow['plate_number'];
    $userCategory = $userRecordsRow['category'];
}

// get total spaces available based on your category
$getTotalSpace = "SELECT * FROM parking_space";
$getTotalSpaceQuery = mysqli_query($link, $getTotalSpace);
while ($totalSpacesAvailable = mysqli_fetch_assoc($getTotalSpaceQuery)) {
    $spaceClassA = $totalSpacesAvailable['classA'];
    $spaceClassB = $totalSpacesAvailable['classB'];
    $spaceClassC = $totalSpacesAvailable['classC'];
}

// get the value of vehicle records based on username
$userTImeIn = "SELECT * FROM vehicle_records WHERE username = '$_SESSION[login_email]'";
$userTimeInQuery = mysqli_query($link, $userTImeIn);

while ($userTImeInRow = mysqli_fetch_assoc($userTimeInQuery)) {
    $date_entry = $userTImeInRow['date_entry'];
    $date_exit = $userTImeInRow['date_exit'];

    if ($date_entry == NULL) {
        $paramValue = '';
    } else if ($date_entry != NULL and $date_exit != NULL) {
        $paramValue = '';
    } else {
        $paramValue = 'disabled';
    }
}

// Class A
$classAEntry = "SELECT * FROM vehicle_records WHERE category = 'A' AND date_exit IS NULL";
$queryclassAEntry = mysqli_query($link, $classAEntry);
$cnt_classA = mysqli_num_rows($queryclassAEntry);

// Class B
$classBEntry = "SELECT * FROM vehicle_records WHERE category = 'B' AND date_exit IS NULL";
$queryclassBEntry = mysqli_query($link, $classBEntry);
$cnt_classB = mysqli_num_rows($queryclassBEntry);

// Class C
$classCEntry = "SELECT * FROM vehicle_records WHERE category = 'C' AND date_exit IS NULL";
$queryclassCEntry = mysqli_query($link, $classCEntry);
$cnt_classC = mysqli_num_rows($queryclassCEntry);

// get class category
$getCategorybyClass = "SELECT * FROM user WHERE email = '$_SESSION[login_email]'";
$getCategorybyClassQuery = mysqli_query($link, $getCategorybyClass);
while ($getCategorybyClassQueryRow = mysqli_fetch_assoc($getCategorybyClassQuery)) {
    $myCategory = $getCategorybyClassQueryRow['category'];
}

$totalSpaces = '';
$warning = '';
$paramValue = '';
switch ($myCategory) {
    case 'A':
        $totalSpaces = $spaceClassA - $cnt_classA;
        if ($totalSpaces === 0) {
            $warning = '<div class="alert alert-danger text-center" role="alert">Oh no! There are parking spaces left!</div>';
            if ($date_entry != NULL) {
                $paramValue = 'disabled';
            }
        }
        if ($totalSpaces !== 0) {
            $warning = '';
            if ($date_entry != NULL) {
                $paramValue = 'disabled';
            }
            if ($date_entry != NULL and $date_exit != NULL) {
                $paramValue = '';
            }
        }
        break;
    case 'B':
        $totalSpaces = $spaceClassB - $cnt_classB;
        if ($totalSpaces === 0) {
            $warning = '<div class="alert alert-danger text-center" role="alert">Oh no! There are parking spaces left!</div>';
            if ($date_entry != NULL) {
                $paramValue = 'disabled';
            }
        }
        if ($totalSpaces !== 0) {
            $warning = '';
            if ($date_entry != NULL) {
                $paramValue = 'disabled';
            }
            if ($date_entry != NULL and $date_exit != NULL) {
                $paramValue = '';
            }
        }
        break;
    case 'C':
        $totalSpaces = $spaceClassC - $cnt_classC;
        if ($totalSpaces === 0) {
            $warning = '<div class="alert alert-danger text-center" role="alert">Oh no! There are parking spaces left!</div>';
            if ($date_entry != NULL) {
                $paramValue = 'disabled';
            }
        }
        if ($totalSpaces !== 0) {
            $warning = '';
            if ($date_entry != NULL) {
                $paramValue = 'disabled';
            }
            if ($date_entry != NULL and $date_exit != NULL) {
                $paramValue = '';
            }
        }
        break;
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
                    <a href="./userIndex.php" class="active">
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
                <?php echo $warning ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                    <div class="card text-center">
                        <div class="card-header bg-darkBlue">
                            User account
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 mx-auto my-2">
                                    <form action="./query/userTimeIn.php?method=add" method="POST">
                                        <input type="hidden" name="userEntry_username" value="<?php echo $userUsername; ?>">
                                        <input type="hidden" name="userEntry_plateNum" value="<?php echo $userPlateNum; ?>">
                                        <input type="hidden" name="userEntry_category" value="<?php echo $userCategory; ?>">
                                        <input type="hidden" name="userEntry_dateEntry" value="<?php echo $dateToday; ?>">
                                        <input type="hidden" name="userEntry_dateParam" value="<?php echo $dateParam; ?>">
                                        <button id="userTimein" class="btn btn-darkBlue user_time" type="submit" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" data-bs-title="TIME IN" <?php echo $paramValue ?>>
                                            <i class="fa-solid fa-clock"></i>
                                        </button>
                                    </form>

                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 my-2">
                                    <form action="./query/userTimeIn.php?method=update" method="POST">
                                        <input type="hidden" name="userExit_username" value="<?php echo $userUsername; ?>">
                                        <input type="hidden" name="userExit_dateExit" value="<?php echo $dateToday; ?>">
                                        <button class="btn btn-darkBlue user_time" type="submit" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="TIME OUT">
                                            <i class="fa-regular fa-clock"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card text-center">
                            <div class="card-header bg-darkBlue">
                                Total Spaces based on your class
                            </div>
                            <div class="card-body">
                                <div class="card-text" style="font-size: 5rem;">
                                    <?php echo $totalSpaces ?>
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