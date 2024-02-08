<?php
session_start();
include(dirname(__DIR__).'/view/header.php');
?>
<link rel="stylesheet" href="../main.css">

<main> 
    <h1>Add Personal Trainer</h1>   
    <p>Personal Trainer Successfully Added
    <ul>
        <a href="add_trainer.php">Return to list of personal trainers</a>
    </ul>
<?php include '../view/footer.php'; ?>