<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
?>
<link rel="stylesheet" href="../main.css">

<main>
    <h1> Client Login </h1>
    <form method = 'post'>
    Email:
    <input type='text' name = 'email'/>
    Password:
    <input type='text' name = 'password'/>
    <input type = 'submit' name = 'login' value = 'Login'/>
    </form>

<?php
    if (isset($_COOKIE['client_id_cookie']))//check if client is already logged in, if so bypass login page
    {
        header("Location:client_landing_page.php");
    }
    else //if not logged in, present login page
    {
        if (isset($_POST['login']))
        {
            //get email and password provided
            $client_email = test_input($_POST['email']);
            $client_password = test_input($_POST['password']);
            try
            {
                //get all relevant information for input email
                $query = "SELECT * FROM clients WHERE email = '$client_email'";
                $client = $db->query($query);
            }
            catch (PDOException $e)
            {
                $_SESSION["error"] = $e;
                header("Location:../database_error.php");
            }

            $row = $client->fetch();
            if (empty($row))
            {
                echo "<label class = error>Member not found</label>";
            }

            elseif ($row['password'] == $client_password)
            {
                //if password matches email, 
                //set user information into cookies and allow user to proceed
                $cookie_firstName = $row['firstName'];
                $cookie_lastName = $row['lastName'];
                $cookie_clientID = $row['clientID'];
                setcookie("client_id_cookie", $cookie_clientID);
                setcookie("client_firstname_cookie", $cookie_firstName);
                setcookie("client_lastname_cookie", $cookie_lastName);
                setcookie("client_email_cookie", $client_email);
                header("Location:client_landing_page.php");
            }
            else
            {
                echo "<label class = error>Invalid email or password</label>";
            }
        }
    }
?>

<?php include '../view/footer.php'; ?>