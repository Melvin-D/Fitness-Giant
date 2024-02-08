<?php 
session_start();
include(dirname(__DIR__).'/view/header.php');
?>
<link rel="stylesheet" href="../main.css">

<main> 
    <h1>Assign Trainer to Workout Session</h1>   
    <p>Workout session assigned to personal trainer successfully.
    <ul>
        <a href="select_workout_session.php">Select Another Workout Session</a>
    </ul>
<?php include '../view/footer.php'; ?>