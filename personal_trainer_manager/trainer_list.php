<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');?>
<link rel="stylesheet" href="../main.css">

<h2>Personal Trainer List</h2>
    <table>
        <tr><th>First Name</th>
        <th>Last name</th>
        <th>Location</th>
        <th>Store Code</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Password</th></tr>

<main>
    <?php 
        try //select all personal trainers from database
        {
            $query = 'SELECT * FROM trainers';
            $trainers = $db->query($query);

            //get all personal trainers
            while ($trainer = $trainers->fetch()) 
            {
                $trainer_ID = $trainer['trainerID'];
                $trainer_firstName = $trainer['firstName'];
                $trainer_lastName = $trainer['lastName'];
                $trainer_location = $trainer['location'];
                $trainer_storeCode = $trainer['franchiseCode'];
                $trainer_email = $trainer['email'];
                $trainer_phone = $trainer['phone'];
                $trainer_password = $trainer['password'];
                
                //fill table with information
                echo "<tr><td>".($trainer_firstName)."</td>";
                echo "<td>".($trainer_lastName)."</td>";
                echo "<td>".($trainer_location)."</td>";
                echo "<td>".($trainer_storeCode)."</td>";
                echo "<td>".($trainer_email)."</td>";
                echo "<td>".($trainer_phone)."</td>";
                echo "<td>".($trainer_password)."</td>";
                echo "<form method='post'>";
                echo "<td><button name='submit' value=$trainer_ID>Delete</button></td></form></tr>";
            }
                echo '</table>';

            if (isset($_POST['submit'])) //if personal trainer deleted, remove from db
            {
                try
                {
                    $trainer_ID = $_POST['submit'];
                    $query = "DELETE FROM trainers WHERE trainerID = '$trainer_ID'";
                    $db->exec($query);
                    header("Refresh:0");
                }
                catch(PDOException $e)
                {
                    $_SESSION["error"] = $e->getMessage();
                    header("Location:database_error.php");
                }
            }
        }
        catch (PDOException $e)
        {
            $_SESSION["error"] = $e;
            header("Location:../database_error.php");
        }
    ?>

    <ul>
        <a href="add_trainer.php">Add Personal Trainer</a>
    </ul>
<?php include '../view/footer.php'; ?>