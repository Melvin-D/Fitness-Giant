<?php
//cycle through all available in database
    include(dirname(__DIR__).'/database_connect.php');

    if (isset($_POST['province']))
    {
        $selected_province = $_POST['province'];
        try
        {
            $franchise_query = "SELECT * FROM gymlocations WHERE franchiseProvince = '$selected_province'";
            $franchises = $db->query($franchise_query);       
            $res = $franchises->fetchAll(PDO::FETCH_ASSOC);
            if (empty($res))
            {
                echo json_encode(false);
            }
            else
            {
                echo json_encode($res);
            }
        }
        catch (PDOException $e)
        {
            $_SESSION["error"] = $e;
            header("Location:../database_error.php");
        }   
    }

    function loadProvinces()
    {
        $dsn = 'mysql:host=localhost; dbname=fitness_giant';
        $username = 'root';
        $password = '';
        $db = new PDO($dsn, $username, $password);

        try
        {
            $province_query = "SELECT * FROM provinces";
            $provinces = $db->query($province_query);       
            $results = $provinces->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
        catch (PDOException $e)
        {
            $_SESSION["error"] = $e;
            header("Location:../database_error.php");
        }   
    }
?>