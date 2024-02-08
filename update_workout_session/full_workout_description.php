<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();?>
<link rel="stylesheet" href="../main.css">

<main>
    <h1>Personal Training Request</h1>   

<?php 
    if($_SERVER["HTTPS"] != "on") //use https
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    //expands the personal training request from client
    $query = "SELECT clientWorkoutRequest FROM trainingsessions where trainingsessionID = " . $_COOKIE['trainingsession_id_cookie'];
    $result = $db->query($query);
    $row = $result->fetch();
?>
    <form method = 'post'>
    <label for id='description' name ='description'>The client would like to focus on:
        <textarea id = 'description' name = 'description' rows ='10' cols = '140'><?php echo $row['clientWorkoutRequest'] ?></textarea>
    </label><br>
    <input type = 'submit' name = 'submit' value = 'Accept workout request'><br>
    </form>

    <?php 
    if (isset($_POST['submit']))
    {
        //if accepted, update database to indicate a trainer has taken the request
        $query = "UPDATE trainingsessions SET trainerID = " . $_COOKIE["trainer_id_cookie"] . " WHERE trainingsessionID = " . $_COOKIE['trainingsession_id_cookie'];
        $db->query($query);
        header("Location:update_workout_session_success.php");
    }
?>

<ul>
    <a href="trainer_landing_page.php">Return to main menu</a>
</ul>

<?php include '../view/footer.php'; ?>