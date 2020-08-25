<?php


require_once __DIR__ . '/vendor/autoload.php';
include("../db/db_connect.php");
//ini_set("display_errors","On");




use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\ModelManager; 
use Phpml\Association\Apriori;



function show($arr){
    foreach($arr AS $record){
        foreach ($record AS $key=>$value){
            echo $key.'=>'.$value.'; Type: '.gettype($value).'<p>';
        }
        echo '================<p>';
    }
}

$iv=array();
$dv=[];


$query='SELECT "Weekday","Month","Year","Is Weekend","Is Holiday","Main Category","Country","Total_Sales"
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
    foreach ($record AS $key=>$value){
        array_push($temp,$value);
    }
    array_push($iv,$temp);
    //array_push($dv,$temp2);

}
show($iv);
// $samples = [[60], [61], [62], [63], [65]];
// $targets = [3.1, 3.6, 3.8, 4, 4.1];
$associator = new Apriori($support = 0.5, $confidence = 0.5);
$associator->train($iv, $dv);
print_r($associator->getRules());
print_r($associator->predict(['1','12','2019','f','f',"藥品","台北市"]));



// $regression = new SVR(Kernel::LINEAR);
// $regression->train($iv, $dv);

//save
// $modelManager = new ModelManager();
// $modelManager->saveToFile($regression, $filepath);



?>