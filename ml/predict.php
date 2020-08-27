<?php


require_once __DIR__ . '/vendor/autoload.php';
include("../db/db_connect.php");
// ini_set("display_errors","On");




use Phpml\Regression\LeastSquares;
use Phpml\ModelManager; 


$output=array();
$filepath = './model/temp';
$modelManager = new ModelManager();
$restoredClassifier = $modelManager->restoreFromFile($filepath);


for ($i=20200701;$i<20200931;$i++){
    if (($i<=20200731) || ($i>=20200801 && $i<=20200831) || ($i>=20200901 && $i<=20200930)){
        
        $output[$i/100]=$output[$i/100]+$restoredClassifier->predict([$i]);
    }
        //echo $i."=>".$restoredClassifier->predict([$i])."<p>";
}
echo json_encode($output);





?>