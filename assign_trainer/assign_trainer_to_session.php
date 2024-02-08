<?php 
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start(); ?>
<link rel="stylesheet" href="../main.css">

<main>
<h1>Assign Trainer to Workout Session</h1>
    <?php
    if($_SERVER["HTTPS"] != "on") //make server run using https
        {
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            exit();
        }

    ob_start();
    $client_id = $_SESSION['clientID']; //get client id passed from session variable

    try
    {
        //get client that matches client id
        $query = "SELECT firstName, lastName FROM clients WHERE clientID = '$client_id'";
        $client_name = $db->query($query);
    }
    catch (PDOException $e)
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    } 
    $row = $client_name->fetch();

    //combine to make full name
    $client_fullName = $row['firstName']. ' ' . $row['lastName'];
    
    //put all needed information into session variables
    $trainerName = $_SESSION['trainerName'];
    $trainerID = $_SESSION['trainerID'];
    $trainingSessionID = $_SESSION["trainingsessionID"];

    echo "<label>Customer: $client_fullName<br>";
    echo "<label>Personal Trainer: $trainerName<br>";
    echo "<label>Training Session ID: $trainingSessionID<br>";
    echo "<form method='post'>";
    echo "<button name='submit' >Assign Personal Trainer to Client</button></form>";

    if (isset($_POST['submit'])) //when assigned, update to put trainerid
    {
        try
        {  
            $query = "UPDATE trainingsessions SET trainerID = '$trainerID' WHERE trainingsessionID = '$trainingSessionID'";
            $db->exec($query);
            header("Location:workout_scheduled_success.php");
        }
        catch (PDOException $e)
        {
            $_SESSION["error"] = $e;
            header("Location:../database_error.php");
        }
    }
?>

<?php include '../view/footer.php'; ?>