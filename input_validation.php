<?php

//function tests data for special characters
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function test_email($data) //ensures email is formatted correctly
{
    if (empty($data))
    {
        return false;
    }
    else
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL))
        {
            return $data;
        }
        else
        {
            return false;
        }
    }
}

function test_character_length($data) //checks length of entries
{
    $length = strlen($data);

    if ($length > 0 && $length < 51)
    {
        return $data;
    }
    else
    {
        return false;
    }
    
}

function test_password($data) //checks length of password
{
    if (strlen($data) < 6 || strlen($data) > 12)
    {
        return false;
    }
    else 
    {
        return $data;
    }
}

function test_phonenumber($data) //checks if phone number is formatted correctly. 
//Since there is only one valid form of phone number, I can check the absolute position of chars in the entry for brackets and hyphens in the correct places
{
    $str = trim(preg_replace('/\s*\([^)]*\)/', '', $data));
    $str_no_hyphen = str_replace('-',"", $str);
    if (is_numeric($str_no_hyphen))
    {
        if ($data[0] == '(' && $data[4] == ')' && $data[5] == ' ' && $data[9] == '-')
        {
            return $data;
        }
        else
        {
            return false;
        }
    }
    else
    {
    return false;
    }
}
function test_date_input($data) //formats date to remove timestamp
{
    $var = preg_split("#/#", $data);

    if (count($var) == 3) 
    {
        return $data;
    }
    else
    {
        return false;
    }
}
?>