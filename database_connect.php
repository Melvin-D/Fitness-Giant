<?php //Connect to database and get all products. Used for all files as a centralized connection point
//Call database using "$db->exec() or $db->query()"
        $dsn = 'mysql:host=localhost; dbname=fitness_giant';
        $username = 'root';
        $password = '';
        $db = new PDO($dsn, $username, $password);
?>
