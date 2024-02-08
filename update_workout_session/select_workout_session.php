<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start(); ?>
<link rel="stylesheet" href="../main.css">

<main>
<h1>Assign yourself to an open workout request.</h1>
<h1>NOTE: You can only choose requests at your franchise code: <?php echo $_COOKIE['trainer_franchisecode_cookie'] ?></h1>
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
        //select all information needed for personal training requests
        $query = "SELECT clients.firstName, clients.clientID, clients.lastName, clients.homeGym, clients.phone, clients.email, trainingsessions.trainingsessionID 
        FROM clients INNER JOIN trainingsessions ON trainingsessions.clientID = clients.clientID AND trainingsessions.trainerID IS NULL";
        $open_training_sessions = $db->query($query);
    }
    catch (PDOException $e)
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    } 

    //get information from saved cookies
    $trainerName = $_COOKIE['trainer_firstname_cookie'];
    $trainerID = $_COOKIE['trainer_id_cookie'];

    while ($open_training_session = $open_training_sessions->fetch()) 
    {
        //fill table with all personal training requests
        $client_ID = $open_training_session['clientID'];
        $client_franchiseCode = $open_training_session['homeGym'];
        $client_firstName = $open_training_session['firstName'];
        $client_lastName = $open_training_session['lastName'];
        $client_phone = $open_training_session['phone'];
        $client_email = $open_training_session['email'];
        $training_session_id = $open_training_session['trainingsessionID'];
        
        echo "<tr><td>".($client_ID)."</td>";
        echo "<td>".($client_franchiseCode)."</td>";
        echo "<td>".($client_firstName)."</td>";
        echo "<td>".($client_lastName)."</td>";
        echo "<td>".($client_phone)."</td>";
        echo "<td>".($client_email)."</td>";
        echo "<form method='post'>";

        //since only personal trainers that work at a clients gym can accept their requests, make button unselectable if not at same location
        if ($client_franchiseCode == $_COOKIE['trainer_franchisecode_cookie'])
        {
            echo "<td><button name='submit' value=$training_session_id>Select</button></td></form></tr>";
        }
        else
        {
            echo "<td><button name='submit' value='' disabled>Select</button></td></form></tr>";
        }
    }
        echo '</table>';

    if (isset($_POST['submit'])) 
    {
        try
        {  
            setcookie("trainingsession_id_cookie", $_POST['submit']);
            header("Location:full_workout_description.php");
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