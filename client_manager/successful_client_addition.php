<?php
session_start();
include(dirname(__DIR__).'/view/header.php');
?>
<link rel="stylesheet" href="../main.css">

<main> 
    <h1>Add Client</h1>   
    <p>Client successfully registered!
    <ul>
        <a href="add_client.php">Register Another Client</a>
    </ul>
<?php include '../view/footer.php'; ?>