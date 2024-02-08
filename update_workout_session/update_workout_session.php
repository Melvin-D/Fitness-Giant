<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start(); ?>
<link rel="stylesheet" href="../main.css">

<main>
<h1>Your Currently Assigned Personal Training Sessions</h1>
    <table>
        <tr><th>Client ID</th>
        <th>Franchise Code</th>
        <th>First Name</th>
        <th>Last name</th>
        <th>Phone Number</th>
        <th>Email</th></tr>

    <?php
    if($_SERVER["HTTPS"] != "on") //make server run using https
        {
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            exit();
        }

    try
    {
        $query = "SELECT clients.firstName, clients.clientID, clients.lastName, clients.homeGym, clients.phone, clients.email, trainingsessions.trainingsessionID
        FROM clients INNER JOIN trainingsessions ON trainingsessions.clientID = clients.clientID WHERE workoutCompleted IS NULL AND trainingsessions.trainerID = " . $_COOKIE['trainer_id_cookie'];
        $assigned_sessions = $db->query($query);
    }
    catch (PDOException $e)
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    } 


    while ($assigned_session = $assigned_sessions->fetch()) 
    {
        $client_ID = $assigned_session['clientID'];
        $client_firstName = $assigned_session['firstName'];
        $client_lastName = $assigned_session['lastName'];
        $client_phone = $assigned_session['phone'];
        $client_email = $assigned_session['email'];
        $training_session_id = $assigned_session['trainingsessionID'];
        
        echo "<tr><td>".($client_ID)."</td>";
        echo "<td>".($client_firstName)."</td>";
        echo "<td>".($client_lastName)."</td>";
        echo "<td>".($client_phone)."</td>";
        echo "<td>".($client_email)."</td>";
        echo "<form method='post'>";
        echo "<td><button name='submit' value='$training_session_id'>Select</button></td></form></tr>";
    }
        echo '</table>';

    if (isset($_POST['submit'])) 
    {
        try
        {  
            setcookie("trainingsession_id_cookie", $_POST['submit']);
            header("Location:edit_selected_workout.php");
        }
        catch (PDOException $e)
        {
            $_SESSION["error"] = $e;
            header("Location:../database_error.php");
        }
    }
?>


<ul>
    <a href="trainer_landing_page.php">Return to main menu</a>
</ul>
<?php include '../view/footer.php'; ?>