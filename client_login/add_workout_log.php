<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();
?>
<head>
<link rel="stylesheet" href="../main.css">
</head>

<body>
<main>
    <h1>Log Workout</h1>
    <form method='post'>
    Date: <input type='text' id='workoutDate' name='workoutDate' value = '<?php echo $_SESSION['workoutDate']?>'></input> Enter any valid date format<br>
    Describe your workout: <textarea rows="50" cols="140" id='workoutDescription' name='workoutDescription'> <?php echo $_SESSION['workoutDescription']?></textarea><br>

    <input type='submit' value='Log your workout' name = 'submit'></button>
    </form>
    
    <?php
        if (isset($_POST['submit'])) //get all information on the page 
        {
            $workout_date = test_input($_POST['workoutDate']);
            $workout_description = test_input($_POST['workoutDescription']);

            //Check if all fields are filled
            if (!empty($workout_date) || !empty($workout_description))
            {
                $d=strtotime($workout_date);
                $date = date("Y-m-d", $d);
                $customerID = $_COOKIE["client_id_cookie"]; 
                try
                {
                    if (isset($_SESSION['workoutID'])) //if the user is editing a pre-existing log, update database
                    {
                        $query = "UPDATE workouts SET workoutDescription = '$workout_description', trainingDate = '$workout_date' WHERE workoutLogID = " . $_SESSION['workoutID'];
                    }
                    else //if user is creating a new log, insert into database
                    {
                        $query = "INSERT INTO workouts (clientID, trainingDate, workoutDescription) VALUES ('$customerID', '$date', '$workout_description')";
                    }
                    //clear unneeded session data after using it
                    $_SESSION['workoutDate'] = '';
                    unset($_SESSION['workoutID']);
                    $_SESSION['workoutDescription'] = '';
                    $db->exec($query);
                    header("Location:workout_log.php");
                }
                catch (PDOException $e)
                {
                    $_SESSION["error"] = $e;
                    header("Location:../database_error.php");
                }
            }
            else
            {
                echo "<label class = error>Please enter data for all fields</label>";
            }  
        }
    ?>
</main>
</body>

<ul><a href="workout_log.php">View Workout Log</a></ul>
<?php include '../view/footer.php'; ?>