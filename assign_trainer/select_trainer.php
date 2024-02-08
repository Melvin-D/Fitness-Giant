<?php 
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start(); ?>
<link rel="stylesheet" href="../main.css">

<h2>Select Personal Trainer</h2>
    <table>
        <tr><th>Name</th>
        <th>Total training Sessions Booked/Completed</th></tr>
<main>
    <?php ///ensure https connection
    if($_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    try
    {
        $query = 'SELECT * FROM trainers WHERE franchiseCode = ' . $_SESSION["clientGymLocation"]; 
        $trainers = $db->query($query);
    
        while ($trainer = $trainers->fetch()) //grab all trainers that are in the same location as selected client
        {
            $trainer_id = $trainer['trainerID'];
            $trainer_full_name = $trainer['firstName'] . ' ' . $trainer['lastName'];
            
            echo "<form method='post'>";
            echo "<tr><td>".($trainer_full_name)."</td>";

            $query = 'SELECT COUNT(trainingsessions.trainerID) from trainingsessions WHERE trainerID = ' .$trainer_id; //list how many sessions have been completed by trainer
            $totalSessions = $db->query($query);
            $scheduled_sessions = $totalSessions->fetch();
            echo "<td>".($scheduled_sessions[0])."</td>";
            echo "<td><button name='submit' value=$trainer_id>Select</button></td></form></tr>";
        }
            echo '</table>';

        if (isset($_POST['submit'])) //when selected, get first and last name of trainer
        {
            $trainer_id = $_POST['submit'];
            $query = "SELECT firstName, lastName FROM trainers WHERE trainerID = $trainer_id";
            $trainer_name = $db->query($query);
            $row = $trainer_name->fetch();
            $tech_full_name = $row['firstName'] .' '. $row['lastName'];
            
            //put full trainer name and id in sessions for next page
            $_SESSION['trainerName'] = $tech_full_name;
            $_SESSION['trainerID'] = $trainer_id;
            header('Location:assign_trainer_to_session.php');
        }
    }
    
    catch (PDOException $e) //on error, redirect to error page
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    }
?>

<?php include '../view/footer.php'; ?>