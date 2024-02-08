<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();
//utilizes AJAX for dynamic dropdown menus
?>
<head>
<link rel="stylesheet" href="../main.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Belew script will dynamically adjust dropdown menu based on what user has selected for province
        (eg. if user selects "BC", dropdown menu for "storeCodes" will only display stores located in BC)-->
<script type="text/javascript">
    $(document).ready(function(){
        $("#provinceDropdown").change(function(){
            var province = $("#provinceDropdown").val();
            $.ajax({
                url: 'get_locations.php',
                method: 'post',
                data: 'province=' + province
            }).done(function(locations){
                locations = JSON.parse(locations);
                $('#storeCodeDropdown').empty();
                if (locations == false)
                {
                    $('#storeCodeDropdown').append('<option>Sorry, we have no locations here right now</option>');
                }
                else
                {
                    locations.forEach(function(locations)
                    {
                        $('#storeCodeDropdown').append('<option>' + locations.franchiseCode + ' </option>')
                    })
                }
                
            })
        })
    })
</script>
</head>

<body>
<main>
    <h1>Add Personal Trainer</h1>
    <form method='post'>
    First name: <input type='text' id='aligned' name='fName'></input><br>
    Last Name: <input type='text' id='aligned' name='lName'></input><br>
    City: <input type='text' id='aligned' name='location'></input><br>
    Province: <select id="provinceDropdown" name = "provinceDropdown">
    <?php
    //load all provinces from database
        require 'get_locations.php';
        $provinces = loadProvinces();

        foreach ($provinces as $row)
        {
            echo "<option value = $row[provinceCode]>$row[provinceName]</option>";
        }
        echo "<option selected disabled>Please select a province</option>";
    ?>
    </select><br><br>
    Store Code: <select name="storeCodeDropdown" id = "storeCodeDropdown">
        <option value="">Please select a province</option>
    </select><br><br>

    Email: <input type='text' id='aligned' name='email'></input><br>
    Phone: <input type='text' id='aligned' name='phone'></input> Enter in "(XXX) XXX-XXXX" format<br>
    Password: <input type='text' id='aligned' name='password'></input> Password must be 7-12 characters<br>
    <input type='submit' value='Add Personal Trainer' name = 'submit'></button>
    </form>
    
    <?php
        if (isset($_POST['submit']))
        {
            //get all information needed to add a new personal trainer
            $trainer_firstName = test_input($_POST['fName']);
            $trainer_lastName = test_input($_POST['lName']);
            $trainer_location = test_input($_POST['location']);
            $trainer_province = $_POST['provinceDropdown'];
            $trainer_storeCode = $_POST['storeCodeDropdown'];
            $trainer_email = test_email($_POST['email']);
            $trainer_phone = test_phonenumber($_POST['phone']);
            $trainer_password = test_password($_POST['password']);

            //Check if all fields are filled
            if (!empty($trainer_firstName) && !empty($trainer_lastName) && !empty($trainer_location) && !empty($trainer_email) && !empty($trainer_phone) && !empty($trainer_password) && is_numeric($trainer_storeCode))
            {
                try
                {
                    //if everything is ok, insert new personal trainer into database
                    $query = "INSERT INTO trainers (firstName, lastName, location, province, franchiseCode, email, phone, password) VALUES
                    ('$trainer_firstName', '$trainer_lastName', '$trainer_location', '$trainer_province', '$trainer_storeCode', '$trainer_email', '$trainer_phone', '$trainer_password')";
                    $db->exec($query);
                    header("Location:../personal_trainer_manager/successful_trainer_addition.php");
                }
                catch (PDOException $e)
                {
                    $_SESSION["error"] = $e;
                    header("Location:../database_error.php");
                }
            }
            else
            {
                echo "<label class = error>Please enter data for all fields</label>";
            }  
        }
    ?>
</main>
</body>

<ul><a href="trainer_list.php">View Trainer List</a></ul>
<?php include '../view/footer.php'; ?>