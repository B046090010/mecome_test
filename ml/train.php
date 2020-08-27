<?php


require_once __DIR__ . '/vendor/autoload.php';
include("../db/db_connect.php");
ini_set("display_errors","On");




use Phpml\ModelManager; 
use Phpml\Regression\LeastSquares;


$iv=array();
$dv=array();
$iv_row=array();
$dv_row=array();
$filepath="./model/temp";



function show($arr){
    foreach($arr AS $record){
        foreach ($record AS $key=>$value){
            echo $key.'=>'.$value.'; Type: '.gettype($value).'<p>';
        }
        echo '================<p>';
    }
}




$query='SELECT *
From (
	SELECT "Sales Date Key",SUM("Total_Sales")
	FROM
		"Sales_Total" as ST left join 
		"Dim_Date" as DD on  ST."Sales Date Key"=DD."Date Key" 
		left join "Dim_Product" as DP on ST."Product Key"=DP."Product Key" 
		left join "Dim_Store" as DS on ST."Store Key"=DS."Store Key"
	WHERE ("Sales Date Key" between 20200401 AND 20200630)  OR ("Sales Date Key" between 20190701 AND 20190731)
	GROUP BY "Sales Date Key"
) AS temp
WHERE random()  < 1';

if($result = pg_query($db, $query)){
    $rows = pg_fetch_all($result);
}
else{
    echo pg_last_error(db);
}


foreach($rows AS $record){
    $iv_row=[];
    $dv_row=[];
    foreach ($record AS $key=>$value){
        $value=(int)$value;
        if ($key == "sum"){
            array_push($dv_row,$value);
        }
        else{
            array_push($iv_row,$value);
        }
    }
    array_push($iv,$iv_row);
    array_push($dv,$dv_row);
}
unset($iv_row);
unset($dv_row);
//show($dv);

$regression = new LeastSquares();
$regression->train($iv, $dv);
//save
$modelManager = new ModelManager();
$modelManager->saveToFile($regression, $filepath);
echo $regression->predict([20200901]);



?>