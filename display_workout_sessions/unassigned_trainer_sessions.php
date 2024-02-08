<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php'); ?>
<link rel="stylesheet" href="../main.css">

<main>
    
<?php //Connect to database and get all assigned personal training requests
    try
    {
        //get all assigned personal training requests
        $query = "SELECT trainingsessions.trainingsessionID, clients.firstName, clients.lastName,
        trainingsessions.clientID, trainingsessions.workoutDate, trainingsessions.clientWorkoutRequest, trainingsessions.trainerID FROM trainingsessions
        LEFT JOIN clients ON clients.clientID = trainingsessions.clientID
        WHERE trainingsessions.trainerID IS NULL";
        $trainer_sessions = $db->query($query);
    }
    catch (PDOException $e)
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    }
?>

    <h2>Unassigned Training Sessions</h2>      
    <ul>
        <a href="assigned_trainer_sessions.php">Assigned/Upcoming Training Sessions</a>
    </ul>
    <table>
    <tr><th>Client</th>
    <th>Date Requested</th></tr>
    
<?php //Keep filling table while there are still entries in database
    while ($trainer_session = $trainer_sessions->fetch()) 
    {
        $workout_client = $trainer_session['firstName']. " " . $trainer_session['lastName'];
        $workout_session_id = $trainer_session['trainingsessionID'];
        $workout_date = $trainer_session['workoutDate'];
        $workout_assigned_trainer = $trainer_session['trainerID'];
        $workout_request = $trainer_session['clientWorkoutRequest'];
        
        echo "<tr><td>".($workout_client)."</td>";
        echo "<td>ID: ".($workout_session_id)."<br>
        Date requested: ".($workout_date)." <br>
        Assigned Trainer: ".($workout_assigned_trainer)." <br>
        Client Request: ".($workout_request)." <br></td></tr>";
    }
    echo '</table>';
?>
<?php include '../view/footer.php'; ?>