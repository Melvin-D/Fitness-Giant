<?php
session_start();
include(dirname(__DIR__).'/view/header.php');
?>
<link rel="stylesheet" href="../main.css">

<main>
    <h1>Successful Workout Request</h1>   
    <p>Your workout request has been processed!</p><br>
    <p>Please allow up to 5 business days for a personal trainer to contact you.</p>

    <ul><a href="client_landing_page.php">Back to main menu</a></ul>
<?php include '../view/footer.php'; ?>