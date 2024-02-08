<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();?>
<link rel="stylesheet" href="../main.css">

<main>
    <h1>All Workouts Logged For <?php echo ($_COOKIE['client_firstname_cookie']. ' ' .$_COOKIE['client_lastname_cookie']);?></h1>  

    <table class="log">
        <tr><th>Date</th>
        <th>Description</th>
        <th>View full log/Update Log</th>
        <th class = "error">Remove</th></tr>
<?php 
    if($_SERVER["HTTPS"] != "on") //use https
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    try 
    {
        //grab all workouts for client ID
        $query = "SELECT * FROM workouts WHERE clientID = ". $_COOKIE["client_id_cookie"];
        $workouts = $db->query($query);   
    }
    catch (PDOException $e)
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    }

    while ($workout = $workouts->fetch()) 
    {
        $workoutlogID = $workout['workoutLogID'];
        $workout_date = $workout['trainingDate'];
        $workout_description = $workout['workoutDescription'];
        
        echo "<tr><td>".($workout_date)."</td>"; ?>
        <td class ="description"><?php echo ($workout_description); ?> </td> 
        <?php
        echo "<form method='post'>";
        echo "<td><button name='update' value=$workoutlogID>Update</button></td>";
        echo "<td><button name='delete' value=$workoutlogID>Delete</button></td></form></tr>";
    }
    echo '</table>';

    if (isset($_POST['update'])) //if user updates then set relevant data in sessions
    {
        $workout_id = $_POST['update'];
        $_SESSION['workoutID'] = $workout_id;
        $_SESSION['workoutDescription'] = $workout_description;
        $_SESSION['workoutDate'] = $workout_date;
        header("Location:add_workout_log.php");
    }
    if (isset($_POST['delete'])) //if user deletes log, delete from database
    {
        $workoutlogID = $_POST['delete'];
        $query = "DELETE FROM workouts WHERE workoutLogID = '$workoutlogID'";
        $db->exec($query);
        header("Refresh:0");
    }
?>

    <ul>
        <a href="add_workout_log.php">Log New Workout</a>
    </ul>
<?php include '../view/footer.php'; ?>