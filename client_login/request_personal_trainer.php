<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();?>
<link rel="stylesheet" href="../main.css">

<main>
    <h1>Request a personal training session</h1>   

<?php 
    if($_SERVER["HTTPS"] != "on") //use https
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
?>
    <form method = 'post'>
    <label for id='description' name ='description'>What would you like to focus on?
        <textarea id = 'description' name = 'description' rows ='10' cols = '140'></textarea>
    </label><br>
    <input type = 'submit' name = 'submit' value = 'Submit workout request'><br>
    </form>

    <?php 
    if (isset($_POST['submit']))
    {
        //get user entered data and todays date (formatted)
        $workout_focus = test_input($_POST['description']);
        $todaysDate = date('Y-m-d');
        if (!empty($workout_focus))
        {
            $client = $_COOKIE["client_id_cookie"];
            try
            {
                //generate a new personal training request with all user information
                $query = "INSERT INTO trainingsessions (clientID, workoutDate, clientWorkoutRequest) VALUES ('$client', '$todaysDate', '$workout_focus')"; 
                $db->exec($query);                
                header("Location:successful_workout_request.php");
            }
            catch (PDOException $e)
            {
                $_SESSION["error"] = $e;
                header("Location:../database_error.php");
            }
        }
        else
        {
            echo "<label class = error>Please fill out the above form</label>";
        }  
    }
?>

<ul><a href="client_landing_page.php">Back to main menu</a></ul>

<?php include '../view/footer.php'; ?>