<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
?>
<link rel="stylesheet" href="../main.css">

<main>
    <h1>Personal Trainer Login</h1>
    <form method = 'post'>
    Email:
    <input type='text' name = 'email'/><br>
    Password:
    <input type='text' name = 'password'/><br>
    <input type = 'submit' name = 'login' value = 'Login'/>
    </form>

<?php 
    if (isset($_COOKIE['trainer_id_cookie'])) //if personal trainer has logged in, skip login page
    {
        header("Location:trainer_landing_page.php");
    }
    else //if not logged in, present login page
    {
        if (isset($_POST['login'])) 
        {
            //get email and password provided
            $trainer_email = test_input($_POST['email']);
            $trainer_password = test_input($_POST['password']);
            try
            {
                //check if provided email match database emails
                $query = "SELECT * FROM trainers WHERE email = '$trainer_email'";
                $trainer = $db->query($query); 
            }
            catch (PDOException $e)
            {
                $_SESSION["error"] = $e;
                header("Location:../database_error.php");
            }

            $row = $trainer->fetch();
            if (empty($row))
            {
                echo "<label class = error>Personal trainer not found!</label>";
            }

            elseif ($row['password'] == $trainer_password) 
            {
                //if a matching email was found, check if password matches entry
                //create cookies for personal trainer that logged in
                $cookie_firstName = $row['firstName'];
                $cookie_lastName = $row['lastName'];
                $cookie_trainerID = $row['trainerID'];
                $cookie_trainer_franchisecode = $row['franchiseCode'];
                setcookie("trainer_id_cookie", $cookie_trainerID);
                setcookie("trainer_franchisecode_cookie", $cookie_trainer_franchisecode);
                setcookie("trainer_firstname_cookie", $cookie_firstName);
                setcookie("trainer_lastname_cookie", $cookie_lastName);
                setcookie("trainer_email_cookie", $trainer_email);
                header("Location:trainer_landing_page.php");
            }
            else
            {
                echo "<label class = error>Invalid email or password</label>";
            }
        }
    }
?>
    
<?php include '../view/footer.php'; ?>