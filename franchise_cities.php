<?php
include 'view/header.php';
include 'input_validation.php';
include 'database_connect.php';
session_start();?>
<link rel="stylesheet" href="../main.css">

<h2>Current Franchise Locations</h2>
    <table>
        <tr><th>City</th></tr>

<main>
    <?php //connect to db
    try
        {
            $selected_province = $_SESSION['franchiseProvince'];
            $query = "SELECT franchiseCity FROM gymlocations WHERE franchiseProvince = '$selected_province'";
            $locations = $db->query($query);

            //list all cities that have franchises in selected province
            while ($location = $locations->fetch()) 
            {
                $franchise_city = $location['franchiseCity'];

                echo "<tr><td>".($franchise_city)."</td></tr>";
            }
                echo '</table>';
        }
        catch (PDOException $e)
        {
            $_SESSION["error"] = $e;
            header("Location:../database_error.php");
        }
    ?>

    <ul>
        <a href="franchise_locations.php">All franchise provinces</a>
    </ul>
<?php include 'view/footer.php'; ?>