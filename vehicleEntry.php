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

date_default_timezone_set("Asia/Manila");
$dateToday = date("d/m/Y h:i a");

include('login/config.php');
$vehicleEntry = "SELECT * FROM vehicle_records WHERE date_exit IS NULL";
$queryVehicleEntry = mysqli_query($link, $vehicleEntry);

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
                    <a href="./">
                        <span class="icon"><i class="fa-solid fa-gauge"></i></span>
                        <span class="item">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./vehicleEntry.php" class="active">
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
                <div class="entry-head mt-3">
                    <button type="button" class="btn btn-darkBlue" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-plus"></i> Add new Entry</button>
                </div>
                <div class="entry-body">
                    <table class="table table-condensed table-hover shadow my-5 table-bordered table-striped">
                        <thead class="bg-darkBlue text-center">
                            <tr>
                                <th width="20%">Username</th>
                                <th width="20%">Plate Number</th>
                                <th width="20%">Entry Date</th>
                                <th width="20%">Category</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            while ($row = mysqli_fetch_assoc($queryVehicleEntry)) {
                                $badge = '';
                                if($row['remarks'] == NULL) {
                                    $badge = '';
                                }else {
                                    $badge = "<span class='badge text-bg-secondary' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-custom-class='custom-tooltip' data-bs-title='$row[remarks]'><i class='fa-solid fa-message' ></i></span>";
                                }
                                echo "
                                <tr>
                                    <td class='entry_td'>$row[username] $badge</td>
                                    <td>$row[plate_num]</td>
                                    <td>$row[date_entry]</td>
                                    <td>$row[category]</td>
                                    <td>
                                        <a href='./pages/editEntry.php?entryId=$row[id]' id='$row[id]'>
                                            <i class='fa-solid fa-pen-to-square'></i>
                                        </a>
                                    </td>
                                </tr>
                                ";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-darkBlue">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Entry</h1>
                    </div>
                    <form action="./query/entryQuery.php?method=add" method="POST">
                        <div class="modal-body">
                            <input type="text" class="form-control my-2" name="entry_username" placeholder="Name" required>
                            <input type="text" class="form-control my-2" name="entry_plateNum" placeholder="Plate Number" required>
                            <div class="row">
                                <div class="col-6 my-2">
                                <input type="text" class="form-control" name="entry_date" value="<?php echo $dateToday ?>" readonly>
                                </div>
                                <div class="col-6 my-2">
                                    <select name="entry_category" class="form-control" required>
                                        <option hidden value="NULL">Category</option>
                                        <option value="A">Class A</option>
                                        <option value="B">Class B</option>
                                        <option value="C">Class C</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-darkBlue">Save</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <script src="./js/action.js"></script>
</body>

</html>