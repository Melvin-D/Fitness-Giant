<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();?>

<link rel="stylesheet" href="../main.css">

<main>
    <h1>Admin Login</h1>
    <form method = 'post'>
    Username:
    <input type='text' name = 'username'/><br>
    Password:
    <input type='text' name = 'password'/><br>
    <input type = 'submit' name = 'login' value = 'Login'/>
    </form>

    <?php //check if admin is already logged in, if so skip login page
        if (isset($_SESSION['admin_id_session']))
        {
            header("Location:admin_menu.php");
        }
        else //if not logged in, get admin information
        {
            if (isset($_POST['login'])) 
            {
                $admin_username = test_input($_POST['username']);
                $admin_password = test_input($_POST['password']);
                try
                {
                    //select all admins
                    $query = "SELECT * from admins";
                    $administrators = $db->query($query); 
                }
                catch (PDOException $e)
                {
                    $_SESSION["error"] = $e;
                    header("Location:../database_error.php");
                }
                $row = $administrators->fetch();
                if (empty($row))
                {
                    echo "<label class = error>Invalid username or password</label>";
                }
                elseif ($row['username'] == $admin_username) //check if admin entered username exists in database
                {
                    if ($row['password'] == $admin_password) //check if admin password matches admin username in database
                    {
                        $_SESSION['admin_id_session'] = $admin_username;
                        header("Location:admin_menu.php");
                    }
                    else
                    {
                        echo "<label class = error>Invalid username or password</label>";
                    }
                }
            }
        }
    ?>

<?php include '../view/footer.php'; ?>