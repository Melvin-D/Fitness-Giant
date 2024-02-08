<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php'); ?>
<link rel="stylesheet" href="../main.css">

<main>
    
<?php //Connect to database and get all personal training requests
    try
    {
        //get all unassigned personal training requests with relevant information
        $query = "SELECT trainingsessions.trainingsessionID, clients.firstName, clients.lastName,
        trainingsessions.clientID, trainingsessions.workoutDate, trainingsessions.clientWorkoutRequest, trainingsessions.trainerWorkoutLog, trainingsessions.workoutCompleted, trainingsessions.trainerID FROM trainingsessions
        LEFT JOIN clients ON clients.clientID = trainingsessions.clientID
        WHERE trainingsessions.trainerID IS NOT NULL";
        $trainer_sessions = $db->query($query);
    }
    catch (PDOException $e)
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    }
?>

    <h2>Assigned/Upcoming Training Sessions</h2>      
    <ul>
        <a href="unassigned_trainer_sessions.php">Unassigned Training Sessions</a>
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
        $workout_comments = $trainer_session['trainerWorkoutLog'];
        $workout_completed = $trainer_session['workoutCompleted'];

        //workout_completed is a BIT in sql, if it's 1 then workout completed, NULL then not.
        if($workout_completed == 1)
        {
            $workout_completed = "Workout Completed";
        }
        else
        {
            $workout_completed = "Workout NOT Completed";
        }
        
        echo "<tr><td>".($workout_client)."</td>";
        echo "<td>ID: ".($workout_session_id)."<br>
        ".($workout_completed)." <br>
        Date requested: ".($workout_date)." <br>
        Assigned Trainer: ".($workout_assigned_trainer)." <br>
        Client Request: ".($workout_request)." <br>
        Trainer Comments: ".($workout_comments)." <br></td></tr>";
    }
    echo '</table>';
?>
<?php include '../view/footer.php'; ?>