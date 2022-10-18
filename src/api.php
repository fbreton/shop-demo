<?php

if ($_GET["kill"])
{
    setFile("1");
    $command = "curl -X POST -H \"Content-type:application/json\" https://us-central1-se-cicd-demo.cloudfunctions.net/deploy-canary -d '{\"user\":\"".$_ENV["EMAIL"]."\"}'";
    echo exec($command);
    echo "New Canary Version Pushed!";
}
   

if ($_GET["run"])
{

    setFile("0");
}

function setFile($content)
{
$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/db.txt","wb");
fwrite($fp,$content);
fclose($fp);
echo "file wrote";
//END
//echo $content;
}

?>