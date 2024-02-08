<?php
include '../view/header.php';
session_start();
//Landing page for client that allows them to manage their workout logs and request a personal training session
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
    <h1>Welcome <?php echo $_COOKIE['client_firstname_cookie']?>!</h1>
    <ul><li><a href="workout_log.php">Manage Workout Log</a></li></ul>
    <ul><li><a href="request_personal_trainer.php">Request a Personal Training Session</a></li></ul>

    <form method='post'> 
    <h1>Login Status</h1>
    <p>You are logged in as 
        <?php 
        $name = $_COOKIE["client_email_cookie"];
        echo $name ?></p>

    <button name='logout'>Log Out</button></form>
    <?php 
        if (isset($_POST["logout"])) //clear all cookies on logout
        {
            setcookie("client_firstname_cookie", "", time() - 3600); 
            setcookie("client_lastname_cookie", "", time() - 3600); 
            setcookie("client_id_cookie", "", time() - 3600); 
            setcookie("client_email_cookie", "", time() - 3600); 

            unset($_COOKIE["client_firstname_cookie"]);
            unset($_COOKIE["client_lastname_cookie"]);
            unset($_COOKIE["client_id_cookie"]);
            unset($_COOKIE["client_email_cookie"]);
            header("Location:login_page.php");
        }
    ?>

</section>

<?php include '../view/footer.php'; ?>