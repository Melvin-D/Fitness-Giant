<?php
session_start();
include(dirname(__DIR__).'/view/header.php');
?>
<link rel="stylesheet" href="../main.css">

<main>
    <h1>Personal Training Request</h1>   
    <p>Personal Training Request Successfully Updated
    <ul>
    <a href="trainer_landing_page.php">Return to main menu</a>
</ul>
    <?php 
        echo "<p>You are logged in as:" .($_COOKIE['trainer_email_cookie'])."</p>"; 
        echo "<button name='logout'>Log Out</button></form>";
        if (isset($_POST["logout"]))  //on logout, clear relevant cookies
        {
            setcookie("trainer_id_cookie", "", time() - 3600); 
            setcookie("trainer_firstname_cookie", "", time() - 3600); 
            setcookie("trainer_lastname_cookie", "", time() - 3600); 
            setcookie("trainer_email_cookie", "", time() - 3600); 
            setcookie("trainer_franchisecode_cookie", "", time() - 3600); 
            header("Location:trainer_login.php");
        }
    ?>
<?php include '../view/footer.php'; ?>