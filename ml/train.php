<?php


require_once __DIR__ . '/vendor/autoload.php';
include("../db/db_connect.php");
//ini_set("display_errors","On");




use Phpml\Regression\SVR;
use Phpml\ModelManager; 
use Phpml\Regression\LeastSquares;
use Phpml\FeatureSelection\VarianceThreshold;
use Phpml\Dataset\ArrayDataset;






function show($arr){
    foreach($arr AS $record){
        foreach ($record AS $key=>$value){
            echo $key.'=>'.$value.'; Type: '.gettype($value).'<p>';
        }
        echo '================<p>';
    }
}

$iv=array();
$dv=array();
$iv_row=array();
$dv_row=array();


$query='SELECT "Weekday","Month","Year","Is Weekend","Is Holiday","Country","Main Category","Total_Sales"
From (
	"Sales_Total" as ST left join 
	"Dim_Date" as DD on  ST."Sales Date Key"=DD."Date Key" 
    left join "Dim_Product" as DP on ST."Product Key"=DP."Product Key" 
    left join "Dim_Store" as DS on ST."Store Key"=DS."Store Key"
) AS temp
Where random() <0.001 
Limit 1000';

if($result = pg_query($db, $query)){
    $rows = pg_fetch_all($result);
}
else{
    echo pg_last_error(db);
}


foreach($rows AS $record){
    $iv_row=[];
    foreach ($record AS $key=>$value){
        if ($key == "Is Weekend" || $key == "Is Holiday"){
            if ($value == 'f') $value=0;
            else $value=1;
            array_push($iv_row,$value);
        }
        else{
            $value=(int)$value;
            if ($key == "Total_Sales"){
                array_push($dv_row,$value);
            }
            else{
                array_push($iv_row,$value);
            }
        }
    }
    array_push($iv,$iv_row);
    array_push($dv,$dv_row);
}
$row=[];




// $regression = new SVR(Kernel::LINEAR);
// $regression->train($iv, $dv);

//save
// $modelManager = new ModelManager();
// $modelManager->saveToFile($regression, $filepath);



?>