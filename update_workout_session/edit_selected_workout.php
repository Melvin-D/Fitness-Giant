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

    //get all personal training requests that have been accepted by trainer
    $query = "SELECT clientWorkoutRequest FROM trainingsessions where trainingsessionID = " . $_COOKIE['trainingsession_id_cookie'];
    $result = $db->query($query);
    $row = $result->fetch();
?>
    <form method = 'post'>
    <label for id='description' name ='clientRequest'>The client would like to focus on:
        <textarea id = 'description' name = 'clientRequest' rows ='10' cols = '130'><?php echo $row['clientWorkoutRequest'] ?></textarea>
    </label><br>
    <label for id='description' name ='trainerLog'>Trainer notes on workout:
        <textarea id = 'description' name = 'trainerLog' rows ='10' cols = '130'></textarea>
    </label><br>
    <input type = 'submit' name = 'submit' value = 'Complete workout request'><br>
    <input type = 'submit' name = 'unassign' value = 'Unassign Request'><br>
    <input type = 'submit' name = 'delete' value = 'Remove Request'><br>
    </form>

    <?php 
    //Trainer can choose to update a log, unassign themselves from a log to make it available to other trainers, or delete the log entirely
    if (isset($_POST['submit']))
    {
        $trainer_notes = test_input($_POST['trainerLog']);
        $query = "UPDATE trainingsessions SET workoutCompleted = 1, trainerWorkoutLog = '$trainer_notes' WHERE trainingsessionID = " . $_COOKIE['trainingsession_id_cookie'];
        $db->query($query);
        header("Location:update_workout_session_success.php");
    }
    if (isset($_POST['unassign']))
    {
        $query = "UPDATE trainingsessions SET trainerID = NULL WHERE trainingsessionID = " . $_COOKIE['trainingsession_id_cookie'];
        $db->query($query);
        header("Location:update_workout_session_success.php");
    }
    if (isset($_POST['delete']))
    {
        $query = "DELETE FROM trainingsessions WHERE trainingsessionID = " . $_COOKIE['trainingsession_id_cookie'];
        $db->query($query);
        header("Location:update_workout_session_success.php");
    }
?>

<ul>
    <a href="trainer_landing_page.php">Return to main menu</a>
</ul>

<?php include '../view/footer.php'; ?>