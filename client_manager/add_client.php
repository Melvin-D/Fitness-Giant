<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();
//AJAX scripts are used here for dropdown menus
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
    <h1>Add Client</h1>
    <form method='post'>
    First name: <input type='text' id='aligned' name='fName'></input><br>
    Last Name: <input type='text' id='aligned' name='lName'></input><br>
    Address <input type='text' id='aligned' name='address'></input><br>
    City: <input type='text' id='aligned' name='city'></input><br>
    Postal Code: <input type='text' id='aligned' name='postcode'></input><br>
    Province: <select id="provinceDropdown" name = "provinceDropdown">
    <?php
    //load all provinces provided in database
        require 'get_locations.php';
        $provinces = loadProvinces();

        foreach ($provinces as $row)
        {
            echo "<option value = $row[provinceCode]>$row[provinceName]</option>";
        }
        echo "<option selected disabled>Please select a province</option>";
    ?>
    </select><br><br>
    Home Gym: <select name="storeCodeDropdown" id = "storeCodeDropdown">
        <option value="">Please select a province</option>
    </select><br><br>

    Phone: <input type='text' id='aligned' name='phone'></input> Enter in "(XXX) XXX-XXXX" format<br>
    Email: <input type='text' id='aligned' name='email'></input><br>
    Password: <input type='text' id='aligned' name='password'></input> Password must be 7-12 characters<br>
    <input type='submit' value='Add Client' name = 'submit'></button>
    </form>
    
    <?php
        if (isset($_POST['submit']))
        {
            //get all information provided in form
            $client_firstName = test_input($_POST['fName']);
            $client_lastName = test_input($_POST['lName']);
            $client_address = test_input($_POST['address']);
            $client_city = test_input($_POST['city']);
            $client_postCode = test_input($_POST['postcode']);
            $client_province = $_POST['provinceDropdown'];
            $client_storeCode = $_POST['storeCodeDropdown'];
            $client_phone = test_phonenumber($_POST['phone']);
            $client_email = test_email($_POST['email']);
            $client_password = test_password($_POST['password']);

            //Check if all fields are filled
            if (!empty($client_firstName) && !empty($client_lastName) && !empty($client_address) && !empty($client_city) && !empty($client_postCode) && !empty($client_phone)
            && !empty($client_email) && !empty($client_password) && is_numeric($client_storeCode))
            {
                try
                {
                    //if all is verified, insert new information into database
                    $query = "INSERT INTO clients (firstName, lastName, address, city, postalCode, provinceCode, homeGym, phone, email, password) VALUES
                    ('$client_firstName', '$client_lastName', '$client_address', '$client_city', '$client_postCode', '$client_province', '$client_storeCode', '$client_phone', '$client_email', '$client_password')";
                    $db->exec($query);
                    header("Location:successful_client_addition.php");
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

<ul><a href="select_client.php">View Client Information</a></ul>
<?php include '../view/footer.php'; ?>