<?php
header('Content-Type: application/json; charset=utf-8');

require_once("db_connect.php");

$query = 
'SELECT lower("Location Key") as "Location",ROUND((SUM("Total_Sales") / SUM(SUM("Total_Sales")) OVER ()),4) AS "Sales(%)"
From "Seat_Map" as SM left join 
	"Sales_Total_Monthly" as STM on ((SM."Store Key"=STM."Store Key") and (SM."Product Key"=STM."Product Key")) left join 
	"Dim_Store" as DS on STM."Store Key"=DS."Store Key" left join
	"Dim_Product" as DP on STM."Product Key"=DP."Product Key"
Where STM."Sales Date Key" = 20200601 and "Total_Sales">1000 and SM."Store Key"=382
Group by "Location"
Order By "Sales(%)" DESC';

if($result = pg_query($db,$query)){
    $data[0]= pg_fetch_all($result);
	// echo json_encode($data);
}
else{
	echo pg_last_error($db);
	exit;
}
$query = 
'SELECT "Product Name Ch" as "Name",lower("Location Key") as "Location","Layer Key" as "Layer",ROUND("Total_Sales") as "Sales"
From "Seat_Map" as SM left join 
	"Sales_Total_Monthly" as STM on ((SM."Store Key"=STM."Store Key") and (SM."Product Key"=STM."Product Key")) left join 
	"Dim_Store" as DS on STM."Store Key"=DS."Store Key" left join
	"Dim_Product" as DP on STM."Product Key"=DP."Product Key"
Where STM."Sales Date Key" = 20200601 and "Total_Sales">1000 and SM."Store Key"=382
Order By "Location"';
if($result = pg_query($db,$query)){
    $data[1]= pg_fetch_all($result);
	echo json_encode($data);
}
else{
	echo pg_last_error($db);
	exit;
}
?>