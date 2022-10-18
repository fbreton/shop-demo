<?php
//SESSION
session_start();
?>
<?php
/**
 * Generates human-readable string.
 *
 * @param string $length Desired length of random string.
 * 
 * retuen string Random string.
 */ 
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
<?php
// API SIGNAL FX TO END CUSTOM METRICS
// <ecointet@signalfx.com
$db = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/db.txt");
//$db = "0";
if ($_GET['metric'] && $_GET['value'] && ($db == "0" || $_GET['metric'] == "ecointet.shop.cart"))
    echo sendCommand($_GET['metric'], $_GET['value']);
else    
    echo "-1";



function sendCommand($metric, $value)
{
    $buyer = $_SESSION['buyer'];
    if ($_GET['customer']) $buyer = $_GET['customer'];

    $data = ' --header "Content-Type: application/json"';
    $data .= ' --header "X-SF-TOKEN: '.$_ENV["TOKEN"].'"';

   // if(is_integer($value))$_SESSION['device']
        $data .= ' --data \'{ "gauge": [{"metric": "'.$metric.'", "value": '.$value.', "dimensions": {"customer": "'.$buyer.'", "platform": "'.$_SESSION["device"].'" }}]}\'';
    //else
      //  $data .= ' --data \'{"key": "'.$metric.'", "value": '.$value.'}\'';
        
    $data .= ' https://ingest.'.$_ENV["REALM"].'.signalfx.com/v2/datapoint';

    return "URL received: ".$_SERVER['REQUEST_URI']."\n\nTrying to send: ".$data." \n\n  OUTPUT: ".exec("curl". $data);
}

?>