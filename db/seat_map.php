<?php
header('Content-Type: application/json; charset=utf-8');

require_once("db_connect.php");
if($_GET['store'] == '-'){
	$store=149;
}
else{
	$pattern = "/[0-9]/";
	preg_match_all($pattern, $_GET['store'], $matches);
	foreach ($matches[0] as $word) {
		$store=$store.$word ;
	}
	$store=intval($store);
}
$start=intval(substr($_GET['start'],0,4))*10000+intval(substr($_GET['start'],5))*100+1;
$end=intval(substr($_GET['end'],0,4))*10000+intval(substr($_GET['end'],5))*100+1;

if($_GET['main']=='-')
	$opt="";
else{
	if($_GET['detail']!='-')
		$opt=' AND "Detail Category" = '."'".$_GET['detail']."'";
	else if($_GET['middle']!='-')
		$opt=' AND "Middle Category" = '."'".$_GET['middle']."'";
	else
		$opt=' AND "Main Category" = '."'".$_GET['main']."'";
}



$query = 
'SELECT lower("Location Key") as "Location",ROUND((SUM("Total_Sales") / SUM(SUM("Total_Sales")) OVER ()),4) AS "Sales(%)"
From "Seat_Map" as SM left join 
	"Sales_Total_Monthly" as STM on ((SM."Store Key"=STM."Store Key") and (SM."Product Key"=STM."Product Key")) left join 
	"Dim_Store" as DS on STM."Store Key"=DS."Store Key" left join
	"Dim_Product" as DP on STM."Product Key"=DP."Product Key"
Where STM."Sales Date Key" BETWEEN '.$start.' AND '.$end.' AND SM."Store Key"='.$store.$opt.'
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
$query = 'SELECT "Product Name Ch" as "Name",lower("Location Key") as "Location","Layer Key" as "Layer",ROUND(ts) as "Sales"
From (
	SELECT STM."Product Key","Store Key",SUM("Total_Sales") as ts
	FROM "Sales_Total_Monthly" as STM LEFT JOIN "Dim_Product" AS DP on STM."Product Key"=DP."Product Key"
	WHERE "Sales Date Key" BETWEEN '.$start.' AND '.$end.' AND STM."Store Key"= '.$store.$opt.' 
	GROUP BY STM."Product Key","Store Key"
	HAVING SUM("Total_Sales") > 500
) as temp 
	left join "Seat_Map" as SM  on ((temp."Store Key"=SM."Store Key") and (temp."Product Key"=SM."Product Key")) 
	left join "Dim_Store" as DS on temp."Store Key"=DS."Store Key" 
	left join "Dim_Product" as DP on temp."Product Key"= DP."Product Key"
Order By "Location","Layer" DESC,"Sales" DESC ';
// 'SELECT "Product Name Ch" as "Name",lower("Location Key") as "Location","Layer Key" as "Layer",ROUND("Total_Sales") as "Sales"
// From "Seat_Map" as SM left join 
// 	"Sales_Total_Monthly" as STM on ((SM."Store Key"=STM."Store Key") and (SM."Product Key"=STM."Product Key")) left join 
// 	"Dim_Store" as DS on STM."Store Key"=DS."Store Key" left join
// 	"Dim_Product" as DP on STM."Product Key"=DP."Product Key"
// Where STM."Sales Date Key" BETWEEN '.$start.' AND '.$end.'AND "Total_Sales">1000 and SM."Store Key"='.$store.$opt.'
// Order By "Location"';
if($result = pg_query($db,$query)){
    $data[1]= pg_fetch_all($result);
	echo json_encode($data);
}
else{
	echo pg_last_error($db);
	exit;
}
?>