<?php

include('../login/config.php');

$method = $_GET['method'];

switch($method) {
    case 'add':
        if( isset($_POST['entry_username']) &&
            isset($_POST['entry_plateNum']) &&
            isset($_POST['entry_date']) &&
            isset($_POST['entry_category']) ) 
        {
            $entry_username = strip_tags($_POST['entry_username']);
            $entry_plateNum = strip_tags($_POST['entry_plateNum']);
            $entry_date = strip_tags($_POST['entry_date']);
            $entry_category = strip_tags($_POST['entry_category']);
            
            $sql = $link->prepare( "INSERT INTO vehicle_records(username, plate_num,date_entry, category) VALUES ('$entry_username', '$entry_plateNum', '$entry_date', '$entry_category') ");
        
            if($sql->execute()) {
                header('Location: ../vehicleEntry.php');
            }else{
                echo "An error occured.";
            }
        }
        break;
    case 'edit':
        if(isset($_POST['entryId'])) {
            $entryId = $_POST['entryId'];
            $edit_entryUsername = $_POST['edit_entryUsername'];
            $edit_entryPlateNum = $_POST['edit_entryPlateNum'];
            $edited_entry = $_POST['edited_entry'];
            $edit_category = $_POST['edit_category'];
            $edit_remarks = $_POST['edit_remarks'];
            $sql = "UPDATE vehicle_records SET username = '$edit_entryUsername', plate_num = '$edit_entryPlateNum', date_edited = '$edited_entry', category = '$edit_category', remarks = '$edit_remarks' WHERE id = $entryId";
            if(mysqli_query($link, $sql)) {
                header('Location: ../vehicleEntry.php');
            }else{
                echo "An error occured.";
            }
        }
        break;
}