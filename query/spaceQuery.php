<?php

include('../login/config.php');

$method = $_GET['method'];

switch($method) {
    case 'classA':
        if(isset($_POST['totalClassA'])){
            $classA = $_POST['totalClassA'];
            $sql = "UPDATE parking_space SET classA = '$classA'";
            if(mysqli_query($link, $sql)) {
                header('Location: ../spaces.php');
            }else{
                echo "An error occured.";
            }
        }
    case 'classB':
        if(isset($_POST['totalClassB'])){
            $classB = $_POST['totalClassB'];
            $sql = "UPDATE parking_space SET classB = '$classB'";
            if(mysqli_query($link, $sql)) {
                header('Location: ../spaces.php');
            }else{
                echo "An error occured.";
            }
        }
    case 'classC':
        if(isset($_POST['totalClassC'])){
            $classC = $_POST['totalClassC'];
            $sql = "UPDATE parking_space SET classC = '$classC'";
            if(mysqli_query($link, $sql)) {
                header('Location: ../spaces.php');
            }else{
                echo "An error occured.";
            }
        }
}