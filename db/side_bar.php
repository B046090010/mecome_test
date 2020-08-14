<?php
header('Content-Type: application/json; charset=utf-8');

require_once("db_connect.php");
$smiddle= $_GET["smiddle"];

$query = 'SELECT DISTINCT "Detail Category" as detail 
FROM "Dim_Product" 
WHERE "Middle Category" = $1';

if($result = pg_query_params($db, $query,array($smiddle))){
	$data= pg_fetch_all($result);
	echo json_encode($data);
}
else{
	echo pg_last_error($db);
	exit;
}
?>