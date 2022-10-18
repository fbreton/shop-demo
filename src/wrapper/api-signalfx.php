<?php
// API SIGNAL FX TO END CUSTOM METRICS
// <ecointet@signalfx.com
if ($_GET['metric'] && $_GET['value'])
    echo sendCommand($_GET['metric'], $_GET['value']);
else    
    echo "No data";



function sendCommand($metric, $value)
{
    $data = ' --header "Content-Type: application/json"';
    $data .= ' --header "X-SF-TOKEN: rb2yT1_ej4yXYkIdSQzp_w"';

    if(is_integer($value))
        $data .= ' --data \'{ "gauge": [{"metric": "'.$metric.'", "value": '.$value.'}]}\'';
    else
        $data .= ' --data \'{"key": "'.$metric.'", "value": '.$value.'}\'';
        
    $data .= ' https://ingest.us0.signalfx.com/v2/datapoint';

    return "Trying to send: ".$data." \n\n  OUTPUT: ".exec("curl". $data);
}

?>