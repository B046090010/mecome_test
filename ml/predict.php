<?php


require_once __DIR__ . '/vendor/autoload.php';
include("../db/db_connect.php");
ini_set("display_errors","On");




use Phpml\Regression\LeastSquares;
use Phpml\ModelManager; 


function show($arr){
    foreach($arr AS $record){
        foreach ($record AS $key=>$value){
            echo $key.'=>'.$value.'<p>';
        }
        echo '================<p>';
    }
}

$iv=array();
$dv=array();
$query='SELECT "Total_Sales","Total_Profit","Total_Cost"
From (
	"Sales_Total" as ST left join 
	"Dim_Date" as DD on  ST."Sales Date Key"=DD."Date Key" left join
	"Dim_Product" as DP on ST."Product Key"=DP."Product Key" left join
	"Dim_Store" as DS on ST."Store Key"=DS."Store Key"
) AS temp
Where random() <0.0001 
Limit 1';

if($result = pg_query($db, $query)){
    $rows = pg_fetch_all($result);
}
else{
    echo pg_last_error(db);
}
foreach($rows AS $record){
    $temp=[];
    $temp2=[];
    foreach ($record AS $key=>$value){
        if($key != "Total_Profit"){
            array_push($temp,$value);
        }
        else{
            array_push($temp2,$value);
        }
    }
    array_push($iv,$temp);
    array_push($dv,$temp2);
}

$filepath = './model/temp';
$modelManager = new ModelManager();
$restoredClassifier = $modelManager->restoreFromFile($filepath);
echo $restoredClassifier->predict([$iv[0][0],$iv[0][1]])."<p>";
echo $dv[0][0]."<p>";




?>