<?php

$host        = "host=ec2-54-146-91-153.compute-1.amazonaws.com";
$port        = "port=5432";
$dbname      = "dbname=dfvs1vb27tqpk4";
$credentials = "user=veavfoyrlcezql password=ea8b2403bb00b5e20d4444b871f6b5ad991ef9c4be6f714b20112782536102ba";

$db = pg_connect( "$host $port $dbname $credentials"  );
if(!$db){
	echo '<script type="text/javascript">';
	echo 'console.log("No!connect fail")';
	echo '</script>';
} else {
	//echo "Opened database successfully\n";
}

function Total($start,$end,$main,$middle,$detail,$area,$country,$town){
	global $db;
	$query='SELECT sum("Total_Sales") as s,sum("Total_Profit") as p,sum("Total_Quantity") as q
	FROM "Sales_Total" as ST inner join 
		"Dim_Product" as DP on ST."Product Key"=DP."Product Key" inner join
		"Dim_Store" as DS on ST."Store Key"= DS."Store Key"
	Where ST."Sales Date Key" between '.$start.' AND '. $end.' 
      and DP."Main Category" '.$main.' AND DP."Middle Category" '.$middle.' AND DP."Detail Category" '.$detail.' AND 
	  DS."Area" '.$area.' AND DS."Country" '.$country.' AND DS."Town" '.$town;
	// $query = 'SELECT sum("Total_Sales") as s,sum("Total_Profit") as p,sum("Total_Quantity") as q
	// FROM "Sales_Total"  
	// WHERE "Sales Date Key" BETWEEN $1 AND $2';
	if($result = pg_query($db, $query)){
	   $row = pg_fetch_array($result);
	   return $row;
	}
	else{
	   echo pg_last_error($db);
	   exit;
	}
}
function input($get){
	$output;
	if(($get == NULL )|| ($get == '-')){
		$output = "IS NOT NULL";
	}
	else{
		$output = '=\''.$get.'\'';
	}
	return $output;
}
//'SELECT COUNT(*) FROM (SELECT DISTINCT LEFT("_SourceSales",25) FROM "Fact_Sales" WHERE "Date" Between $1 AND $2) AS temp'

//pg_close($db);
?>