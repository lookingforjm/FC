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

date_default_timezone_set("Asia/Manila");
$dateToday = date("d/m/Y h:i a");

$sql = "SELECT * FROM vehicle_records WHERE id = $_GET[entryId]";
$query = mysqli_query($link, $sql);

$entry = mysqli_fetch_assoc($query);

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
                    <a href="../vehicleEntry.php" class="active">
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
                    <a href="../spaces.php">
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
                    <a href="../vehicleEntry.php" class="btn btn-darkBlue noselect" id="goBackEntry">
                        <span class="text">Go back</span><span class="icon">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </span>
                    </a>
                </div>
                <div class="entry-body ">
                    <div class="card m-auto" style="width: 50%">
                        <div class="card-header bg-darkBlue">
                            <span class="entry_dateEdit"><strong>Date of editing:</strong> <i><?php echo $dateToday?></i></span>
                        </div>
                        <div class='card-body'>
                            <p class='card-text'>
                            <form action="../query/entryQuery.php?method=edit" method="POST">
                                <input type="hidden" name="entryId" value="<?php echo $entry['id'] ?>">
                                <input type="hidden" name="edited_entry" value="<?php echo $dateToday?>">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="w-100">Username
                                            <input type="text" name="edit_entryUsername" placeholder="Blog Title" class="form-control mb-2" value="<?php echo $entry['username'] ?>">
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="w-100">Plate number
                                            <input type="text" name="edit_entryPlateNum" placeholder="Blog Title" class="form-control mb-2" value="<?php echo $entry['plate_num'] ?>">
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="w-100">Entry Date
                                            <input type="text" name="edit_dateEntry" placeholder="Blog Title" class="form-control mb-2" value="<?php echo $entry['date_entry'] ?>" disabled>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="w-100">Category
                                            <select name="edit_category" class="form-control">
                                                <option value="<?php echo $entry['category'] ?>" hidden>Class <?php echo $entry['category'] ?></option>
                                                <option value="A" <?php echo $entry['category'] == "A" ? 'Selected' : '' ?> >Class A</option>
                                                <option value="B" <?php echo $entry['category'] == "B" ? 'Selected' : '' ?>>Class B</option>
                                                <option value="C" <?php echo $entry['category'] == "C" ? 'Selected' : '' ?>>Class C</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="w-100">Remarks
                                            <textarea name="edit_remarks" rows="5" class="form-control"><?php echo $entry['remarks']?></textarea>
                                        </label> 
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-darkBlue w-100">Update</button>
                                    </div>
                                </div>

                            </form>
                            </p>
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