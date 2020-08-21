<?php
header('Content-Type: application/json; charset=utf-8');

require_once("db_connect.php");
session_start();

$start= $_SESSION["start"];
$end= $_SESSION["end"];
$main=$_SESSION['main'];
$middle=$_SESSION['middle'];
$detail=$_SESSION['detail'];
$area=$_SESSION['area'];
$country=$_SESSION['country'];       
$town=$_SESSION['town'];
if (($start/100%100)==1){
	$temp=$start-10000+1100;
}
else
	$temp=$start-100;
$query = 'SELECT "Sales Date Key"/100 as ym,SUM("Total_Profit") 
FROM "Sales_Total_Monthly" as STM left join 
		"Dim_Product" as DP on STM."Product Key"=DP."Product Key" left join
		"Dim_Store" as DS on STM."Store Key"= DS."Store Key" 
WHERE (("Sales Date Key" BETWEEN '.$temp.' AND '.$end.') OR ("Sales Date Key" BETWEEN '. ($start-10000).' AND '.($end-10000).')) 
	AND DP."Main Category" '.$main.' AND DP."Middle Category" '.$middle.' AND DP."Detail Category" '.$detail.' AND 
	DS."Area" '.$area.' AND DS."Country" '.$country.' AND DS."Town" '.$town.' 
GROUP BY ym 
ORDER BY ym';

if($result = pg_query($db, $query)){
	$data= pg_fetch_all($result);
	echo json_encode($data);
}
else{
	echo pg_last_error($db);
	exit;
}
?>