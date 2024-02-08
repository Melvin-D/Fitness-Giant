<?php
include '../view/header.php';
session_start();
//landing page for personal trainers to select their options
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
    <h1>Welcome <?php echo $_COOKIE['trainer_firstname_cookie']?>!</h1>
    <ul><li><a href="select_workout_session.php">Select an open personal training request</a></li></ul>
    <ul><li><a href="update_workout_session.php">Update an assigned personal training request</a></li></ul>

    <form method='post'> 
    <h1>Login Status</h1>
    <p>You are logged in as 
        <?php 
        $name = $_COOKIE["trainer_email_cookie"];
        echo $name ?></p>

    <button name='logout'>Log Out</button></form>
    <?php 
        if (isset($_POST["logout"])) //clear all cookies on logout
        {
            setcookie("trainer_firstname_cookie", "", time() - 3600); 
            setcookie("trainer_lastname_cookie", "", time() - 3600); 
            setcookie("trainer_id_cookie", "", time() - 3600); 
            setcookie("trainer_email_cookie", "", time() - 3600); 

            unset($_COOKIE["trainer_firstname_cookie"]);
            unset($_COOKIE["trainer_lastname_cookie"]);
            unset($_COOKIE["trainer_id_cookie"]);
            unset($_COOKIE["trainer_email_cookie"]);
            header("Location:trainer_login.php");
        }
    ?>

</section>

<?php include '../view/footer.php'; ?>