<?php

include('../login/config.php');

$method = $_GET['method'];

switch($method) {
    case 'add':
        if( isset($_POST['userEntry_username']) &&
            isset($_POST['userEntry_plateNum']) &&
            isset($_POST['userEntry_dateEntry']) &&
            isset($_POST['userEntry_category']) &&
            isset($_POST['userEntry_dateParam']) ) 
        {
            $entry_username = strip_tags($_POST['userEntry_username']);
            $entry_plateNum = strip_tags($_POST['userEntry_plateNum']);
            $entry_date = strip_tags($_POST['userEntry_dateEntry']);
            $entry_category = strip_tags($_POST['userEntry_category']);
            $userEntry_dateParam = strip_tags($_POST['userEntry_dateParam']);
            
            $sql = $link->prepare( "INSERT INTO vehicle_records(username, plate_num, date_entry, category, dateParam) VALUES ('$entry_username', '$entry_plateNum', '$entry_date', '$entry_category', '$userEntry_dateParam') ");
        
            if($sql->execute()) {
                header('Location: ../userIndex.php');
            }else{
                echo "An error occured.";
            }
        }
        break;
    case 'update':
        if(isset($_POST['userExit_username'])) {
            $userExit_username = $_POST['userExit_username'];
            $userExit_dateExit = $_POST['userExit_dateExit'];
            $sql = "UPDATE vehicle_records SET date_exit = '$userExit_dateExit' WHERE username = '$userExit_username' AND date_exit IS NULL";
            if(mysqli_query($link, $sql)) {
                header('Location: ../userIndex.php');
            }else{
                echo "An error occured.";
            }
        }
        break;
}