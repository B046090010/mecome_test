<?php
   header('Content-Type: application/json; charset=utf-8');
   require_once("db_connect.php");

   $query='SELECT DD."Date" as ds, SUM("Total_Sales") as y
   FROM "Sales_Total" as ST left join "Dim_Date" as DD on ST."Sales Date Key" = DD."Date Key"
   GROUP BY ds';
   if($result = pg_query($db, $query)){
      $data= pg_fetch_all($result);
      $data=json_encode($data);
   }
   else{
      echo pg_last_error($db);
      exit;
   }
   $url="https://forecastesales.herokuapp.com/sendjson2/";
   $curl = curl_init($url);
   curl_setopt($curl, CURLOPT_HEADER, false);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_exec($curl);
   
   echo json_decode(file_get_contents('php://input','r'), true);

   curl_close($curl);
?>