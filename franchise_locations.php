<?php
include 'view/header.php';
include 'database_connect.php';
session_start();?>
<link rel="stylesheet" href="../main.css">

<h2>Current Franchise Locations</h2>
    <table>
        <tr><th>Province</th>
        <th>Number of locations</th></tr>

<main>
    <?php //connect to db
    try
        {
            $query = 'SELECT franchiseProvince, COUNT(franchiseProvince) FROM gymlocations GROUP BY franchiseProvince';    
            $locations = $db->query($query);

            //get all franchises by province
            while ($location = $locations->fetch()) 
            {
                $franchise_province = $location['franchiseProvince'];
                $franchise_count = $location['COUNT(franchiseProvince)'];

                echo "<tr><td>".($franchise_province)."</td>";
                echo "<td>".($franchise_count)."</td>";
                echo "<form method='post'>";
                echo "<td><button name='submit' value=$franchise_province>Cities</button></td></form></tr>";
            }
                echo '</table>';

            if (isset($_POST['submit'])) //if province selected, display cities that franchises are located in
            {
                try
                {
                    $franchise_province = $_POST['submit'];
                    $_SESSION['franchiseProvince'] = $franchise_province;
                    header("Location:franchise_cities.php");
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

<?php include 'view/footer.php'; ?>