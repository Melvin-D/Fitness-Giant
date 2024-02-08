<?php
include 'view/header.php';

session_start();
//page for when database connection has errors
?>
<link rel="stylesheet" href="main.css">

<main>
    <h1>Database Error</h1>   
    <p>An error occurred while attempting to work with the database</p>
    <p>Message: 
        <?php echo $_SESSION["error"]; ?>

        
<?php include 'view/footer.php'; ?>