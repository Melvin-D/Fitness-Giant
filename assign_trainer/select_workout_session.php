<?php 
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start(); ?>
<link rel="stylesheet" href="../main.css">

<h2>Select Open Workouts</h2>
    <table>
        <tr><th>Client</th>
        <th>Date Scheduled</th>
        <th>Client Request</th>

<main>
    <?php
    if($_SERVER["HTTPS"] != "on") //make connection through https
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    ob_start();
    try
    {
        //displays all personal training requests that are unfufilled
        $query = 'SELECT * FROM trainingsessions WHERE trainerID IS NULL';
        $scheduled_workouts = $db->query($query);

        if ($scheduled_workouts->rowCount() == 0)
        {
            echo '<label>No upcoming workouts scheduled</label>';
        }
        else
        {
            while ($scheduled_workout = $scheduled_workouts->fetch()) 
            {
                $training_session_id = $scheduled_workout['trainingsessionID'];
                $client_id = $scheduled_workout['clientID'];
                $workout_date = $scheduled_workout['workoutDate'];
                $workout_request = $scheduled_workout['clientWorkoutRequest'];
                
                echo "<tr><td>".($client_id)."</td>";
                echo "<td>".($workout_date)."</td>";
                echo "<td>".($workout_request)."</td>";
                echo "<form method='post'>";
                echo "<td><button name='submit' value=$training_session_id>Assign a trainer</button></td></form></tr>";
            }
                echo '</table>';
        }
            
        if (isset($_POST['submit'])) 
        {
            try
            {
                //get selected personal training request
                $training_session_id = $_POST['submit'];
                $query = "SELECT * FROM trainingsessions WHERE trainingsessionID = $training_session_id";
                $workout_info = $db->query($query);
                $row = $workout_info->fetch();

                $_SESSION["trainingsessionID"] = $row['trainingsessionID'];
                $_SESSION["clientID"] =  $row['clientID'];
                $_SESSION["workoutDate"] =  $row['workoutDate'];
                
                //get client gym code to match with trainer at that specific branch
                $query = "SELECT homeGym FROM clients WHERE clientID = " . $_SESSION["clientID"];
                $city_info = $db->query($query);
                $row = $city_info->fetch(); 

                //create a session with clients gym
                $_SESSION["clientGymLocation"] = $row['homeGym'];
                header("Location:select_trainer.php");
            }
            catch(PDOException $e)
            {
                $_SESSION["error"] = $e->getMessage();
                header("Location:database_error.php");
            }
        }
        }
    catch (PDOException $e)
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    }
?>

<?php include '../view/footer.php'; ?>