<?php

// heroku
$host        = "host=ec2-54-146-91-153.compute-1.amazonaws.com";
$port        = "port=5432";
$dbname      = "dbname=dfvs1vb27tqpk4";
$credentials = "user=veavfoyrlcezql password=ea8b2403bb00b5e20d4444b871f6b5ad991ef9c4be6f714b20112782536102ba";

//localhost
// $host        = "host=127.0.0.1";
// $port        = "port=5432";
// $dbname      = "dbname=test";
// $credentials = "user=postgres password=asshole425012";

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
function Tables($start,$end,$main,$middle,$detail,$area,$country,$town,$select,$group,$order,$limit){
	global $db;

	//where&from
	$from_where=' FROM "Sales_Total" as ST inner join 
	"Dim_Product" as DP on ST."Product Key"=DP."Product Key" inner join
	"Dim_Store" as DS on ST."Store Key"= DS."Store Key"
	Where ST."Sales Date Key" between '.$start.' AND '. $end.' 
	and DP."Main Category" '.$main.' AND DP."Middle Category" '.$middle.' AND DP."Detail Category" '.$detail.' AND 
	DS."Area" '.$area.' AND DS."Country" '.$country.' AND DS."Town" '.$town;

	//group
	if ($group=="Year")
	   $group='"Sales Date Key"/10000';
	elseif($group=="Month")
	   $group='"Sales Date Key"/100';
	elseif ($group=="Day")
	   $group='"Sales Date Key"';
	elseif ($group!="Product Name")
	   $group='"'.$group.'"';

	$temp_select='SELECT '.$group.' AS item,';

	if ($group=="Product Name"){
	   $group='DP."Product Key"';
	   $temp_select='SELECT "Product Name Ch", ';
	}
	
	//select
	$select=explode(",", $select);

	foreach($select as $opt){
	   if ($opt=="Profit")
		  $opt = 'SUM("Total_Profit") as p,';
	   else if ($opt == "Sales Amount")
		  $opt = 'SUM("Total_Sales") as s,';
	   else if ($opt == "Quantity")
		  $opt = 'SUM("Total_Quantity") as q,';
	   else{
		  //$opt=preg_split('/\(|\)/', $value)[1];
		  $opt ='(SUM("Total_Profit") / SUM(SUM("Total_Profit")) OVER ()) AS "Percentage",';
		  // echo $opt;
		  // unset($opt);
	   }
	   $temp_select=$temp_select.$opt;
	} 
	$temp_select= substr($temp_select, 0, -1);


	//order
	if ($order == "Profit")
	   $order='p';
	elseif ($order == "Sales Amount")
	   $order='s';
	else
	   $order='q';
	//limit
	if ($limit == "First 100 rows")
	   $limit=' DESC LIMIT 100';
	elseif ($limit == "Last 100 rows"){
	   $limit=' ASC LIMIT 100';
	}
	else
	   $limit=' DESC';

	//query
	$query=$temp_select.$from_where.' GROUP BY '.$group.' ORDER BY '.$order.$limit;
	//result
	if($result = pg_query($db, $query)){
	   $data= pg_fetch_all($result);
	   return $data;
	}
	else{
	   echo pg_last_error($db);
	   exit;
	}
	
 }
//'SELECT COUNT(*) FROM (SELECT DISTINCT LEFT("_SourceSales",25) FROM "Fact_Sales" WHERE "Date" Between $1 AND $2) AS temp'

//pg_close($db);
?>