<?php


require_once __DIR__ . '/vendor/autoload.php';
include("/Users/guoshiqi/Desktop/phptest/Summer_Project/db/db_connect.php");




use Phpml\Classification\KNearestNeighbors;;

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
$query='SELECT "Weekday","Year","Month","Day","Total_Profit"
From (
	"Sales_Total" as ST left join 
	"Dim_Date" as DD on  ST."Sales Date Key"=DD."Date Key" left join
	"Dim_Product" as DP on ST."Product Key"=DP."Product Key" left join
	"Dim_Store" as DS on ST."Store Key"=DS."Store Key"
) AS temp
Where random() <0.0001 
Limit 10';

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
//show($iv,$dv);
$classifier = new KNearestNeighbors();
$classifier->train($iv, $dv);
$classifier->predict([1,2020,6,8]);
?>