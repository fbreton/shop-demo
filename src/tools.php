<?php
session_start();
//ACTIONS
if ($_GET["action"] == "update-customer")
{
    $_SESSION["buyer"] = $_GET["value"];
    die("New Session Name! customer: [".$_SESSION["buyer"]."]");
}

//END


//NAME GENERATOR
function readable_random_string($length = 6)
{  
    $string     = '';
    $vowels     = array("a","e","i","o","u");  
    $consonants = array(
        'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 
        'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
    );  

    // Seed it
    srand((double) microtime() * 1000000);

    $max = $length/2;
    for ($i = 1; $i <= $max; $i++)
    {
        $string .= $consonants[rand(0,19)];
        $string .= $vowels[rand(0,4)];
    }

    return $string;
}


?>