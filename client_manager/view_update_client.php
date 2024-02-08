<?php
include(dirname(__DIR__).'/view/header.php');
include(dirname(__DIR__).'/input_validation.php');
include(dirname(__DIR__).'/database_connect.php');
session_start();
//AJAX scripts are used here for dropdown menus
?>
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

<main>
<?php 
    //get clients ID passed from previous page
    $clientID = $_GET['myVar'];
    
    $client_firstName = $client_lastName = $client_address = $client_city = $client_postCode = $client_storeCode = $client_phone = $client_email = $client_password = '';
    ob_start();
    try
    {
        //get all info for clientID
        $query = "SELECT * FROM clients WHERE clientID = '$clientID'";
        $clients = $db->query($query);
    }
    catch (PDOException $e)
    {
        $_SESSION["error"] = $e;
        header("Location:../database_error.php");
    }
    
    while ($client = $clients->fetch()) 
    {
        //get all relevant information for client
        $client_firstName = $client['firstName'];
        $client_lastName = $client['lastName'];
        $client_address = $client['address'];
        $client_city = $client['city'];
        $client_postCode = $client['postalCode'];
        $client_province = $client['provinceCode'];
        $client_storeCode = $client['homeGym'];
        $client_phone = $client['phone'];          
        $client_email = $client['email'];
        $client_password = $client['password'];
    }

    echo '<h1>View/Update Client</h1>';
    echo "<form method='post'>";
    echo "First Name: <input type='text' name = 'fName' value = '".($client_firstName)."'></input><br><br>";
    echo "Last Name: <input type='text' name = 'lName' value = '".($client_lastName)."'></input><br><br>";
    echo "Address: <input type='text' name = 'address' value = '".($client_address)."'></input><br><br>";
    echo "City: <input type='text' name = 'city' value = '".($client_city)."'></input><br><br>";
    echo "Postal Code: <input type='text' name = 'postalCode' value = '".($client_postCode)."'></input><br><br>";
?>
    Province: <select id="provinceDropdown" name = "provinceDropdown">
<?php
//get all provinces and load them into a dropdown menu, when selected display all available stores in the province
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

<?php
    echo "</select><br><br>";
    echo "Phone: <input type='text' name='phone' value = '".($client_phone)."'></input><br><br>";
    echo "Email: <input type='text' name='email' value = '".($client_email)."'></input><br><br>";
    echo "Password: <input type='text' name='password' value = '".($client_password)."'></input><br><br>";
    echo "<input type='submit' value='Update Client' name = 'submit'></button>";
    echo "</form>";

    if ($_POST['submit'])
    {
        //check if all fields are full
        if(!empty($client_firstName) && !empty($client_lastName) && !empty($client_address) && !empty($client_postCode) && !empty($client_phone) &&!empty($client_email) && !empty($client_password)) 
        {
            $client_firstName = test_character_length($_POST['fName']);
            $client_lastName = test_character_length($_POST['lName']);
            $client_address = test_character_length($_POST['address']);
            $client_city = test_character_length($_POST['city']);
            $client_postCode = test_character_length($_POST['postalCode']);
            $client_province = $_POST['provinceDropdown'];
            $client_storeCode = $_POST['storeCodeDropdown'];
            $client_phone = test_phonenumber($_POST['phone']);          
            $client_email = test_email($_POST['email']);
            $client_password = test_password($_POST['password']);
            
            //check if test functions returned any false values
            if ($client_firstName == false || $client_lastName == false || $client_address == false || $client_city == false || $client_postCode == false || $client_phone == false || $client_email == false || $client_password == false )
            {
                echo "<label class = error>Ensure name between 1 and 51 characters</label><br>
                <label class = error>Ensure password is between 7 and 12 characters</label><br>
                <label class = error>Ensure Phone number is as follows (XXX) XXX-XXXX</label><br>";
            }
            else
            {
                try
                {
                    //if all is accepted, update client from clientID based on new information given by user
                    $query = "UPDATE clients SET firstName='$client_firstName',lastName='$client_lastName',address='$client_address',city='$client_city',
                    provinceCode='$client_province',postalCode='$client_postCode',homeGym='$client_storeCode',phone='$client_phone',email='$client_email',password='$client_password' WHERE clientID = '$clientID'";
                    $db->exec($query);
                    echo "<label class = success>Client successfully updated</label><br>";
                }
                catch (PDOException $e)
                {
                    $_SESSION["error"] = $e;
                    header("Location:../database_error.php");
                }
            }
        }
        else
        {
            echo "<label class = error>All fields must be filled</label>";
        }  
    }
?>

<ul>
    <a href="select_client.php">Search Clients</a>
</ul>

<?php include '../view/footer.php'; ?>
