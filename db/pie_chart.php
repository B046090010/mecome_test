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
$temp=[];
if ($detail!='IS NOT NULL'){
	$temp[0]= '"Product Name Ch"';
	$temp[1]='DP."Product Key"';
}
else if ($middle!='IS NOT NULL' ){
	$temp[0]= '"Detail Category"';
	$temp[1]='"Detail Category"';
}
else if ($main!='IS NOT NULL'){
	$temp[0]= '"Middle Category"';
	$temp[1]='"Middle Category"';
}
else{
	$temp[0]= '"Main Category"';
	$temp[1]='"Main Category"';
}

$query = 'SELECT '.$temp[0].' AS c,SUM("Total_Profit") 
FROM "Sales_Total_Monthly" as STM left join 
		"Dim_Product" as DP on STM."Product Key"=DP."Product Key" left join
		"Dim_Store" as DS on STM."Store Key"= DS."Store Key"
WHERE STM."Sales Date Key" between '.$start.' AND '. $end.' 
and DP."Main Category" '.$main.' AND DP."Middle Category" '.$middle.' AND DP."Detail Category" '.$detail.' AND 
DS."Area" '.$area.' AND DS."Country" '.$country.' AND DS."Town" '.$town.'
GROUP BY '.$temp[1].'  
ORDER BY SUM("Total_Profit") DESC';

// echo $query;
if($result = pg_query($db, $query)){
	$data= pg_fetch_all($result);
	echo json_encode($data);
}
else{
	echo pg_last_error($db);
	exit;
}



// $result = mysqli_query($con,$query);

// $data = array();
// foreach ($result as $row) {
// 	$data[] = $row;
// }


// echo json_encode($data);

?>