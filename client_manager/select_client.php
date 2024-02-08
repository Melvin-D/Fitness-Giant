<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();?>
<link rel="stylesheet" href="../main.css">

<main>
    <h1>Client Search</h1>
    <form method='post'>
    Last Name: <input type='text' id='lName' name='lName'></input>
    <input type='submit' value='Search' name = 'submit'>
    </form>

<?php
    if (isset($_POST['submit']))
    {
        try
        {
            //get clients last name from userinput and search database for client
            $client_lastName = test_input($_POST['lName']);
            $query = "SELECT * FROM clients WHERE lastName = '$client_lastName'";
            $clients = $db->query($query);
            if ($clients->rowCount() > 0)
            {
                echo '<h1>Results</h1>';
                echo '<table>';
                echo '<tr><th>Name</th>';
                echo '<th>Email Address</th>';
                echo '<th>Home Gym Code</th>';
                echo '<th>City</th></tr>';
                while ($client = $clients->fetch()) 
                {
                    //return all clients with matching last name
                    $client_ID = $client['clientID'];
                    $client_fName = $client['firstName'];
                    $client_lName = $client['lastName'];
                    $client_email = $client['email'];
                    $client_homegym = $client['homeGym'];
                    $client_city = $client['city'];
                    
                    echo "<tr><td>".($client_fName . ' ' . $client_lName)."</td>";
                    echo "<td>".($client_email)."</td>";
                    echo "<td>".($client_homegym)."</td>";
                    echo "<td>".($client_city)."</td>";
                    
                    echo '<form method="POST" action = "view_update_client.php?myVar='.$client_ID.'">';
                    echo "<td><Button type='submit' name='submit'>Select</td></form></tr>";
                }
                echo '</table>';
            }
            else //if no entries, user is not registered
            {
                echo "<label class = error>Last name does not exist in our database</label>";
            }  

            //if user selects a client then set their ID as a session and proceed
            if (isset($_POST['select']))
            {
                $_SESSION['client_ID'] = $_POST['select'];
                header("Location:view_update_client.php");
            }
        }
        catch (PDOException $e)
        {
            $_SESSION["error"] = $e;
            header("Location:../database_error.php");
        }
    }
?>
    <ul>
        <a href="add_client.php">Register New Client</a>
    </ul>

<?php include '../view/footer.php'; ?>