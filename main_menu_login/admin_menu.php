<?php
include '../view/header.php';
session_start();
//landing page for all admin features
?>
<link rel="stylesheet" href="../main.css">

<main>
    <?php if($_SERVER["HTTPS"] != "on")
        {
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            exit();
        }
    ?>
    <nav>
    <h1>Admin Menu</h1>
    <ul><li><a href="../personal_trainer_manager/trainer_list.php">Manage Personal Trainers</a></li></ul>
    <ul><li><a href="../client_manager/select_client.php">Manage Clients</a></li></ul>
    <ul><li><a href="../assign_trainer/select_workout_session.php">Assign Personal Trainer to Client</a></li></ul>
    <ul><li><a href="../display_workout_sessions/unassigned_trainer_sessions.php">Display Training Requests</a></li></ul>

    <form method='post'> 
    <h1>Login Status</h1>
    <p>You are logged in as 
        <?php 
        $name = $_SESSION["admin_id_session"];
        echo $name ?></p>
    <button name='logout'>Log Out</button></form>
    <?php 
    if (isset($_POST["logout"])) 
        {    
            unset($_SESSION["admin_id_session"]); 
            header("Location:../index.php");
        }
    ?>
</section>
<?php include '../view/footer.php'; ?>