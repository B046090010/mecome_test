<?php
   header('Content-Type: application/json; charset=utf-8');
   require_once("db_connect.php");
   function http_post_data($url, $data) {  
       
      //將陣列轉成json格式
      $data = json_encode($data);
      
      //1.初始化curl控制代碼
       $ch = curl_init(); 
       
       //2.設定curl
       //設定訪問url
       curl_setopt($ch, CURLOPT_URL, $url);  
       
       //捕獲內容，但不輸出
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       
       //模擬傳送POST請求
       curl_setopt($ch, CURLOPT_POST, 1);  
       
       //傳送POST請求時傳遞的引數
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
       
       //設定頭資訊
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
           'Content-Type: application/json; charset=utf-8',  
           'Content-Length: ' . strlen($data))  
       );  

       //3.執行curl_exec($ch)
       $return_content = curl_exec($ch);  
       
       //如果獲取失敗返回錯誤資訊
       if($return_content === FALSE){ 
           $return_content = curl_errno($ch);
       }
       
       $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
       
       //4.關閉curl
       curl_close($ch);
       
       return array($return_code, $return_content);  
   }

   $query='SELECT DD."Date" as ds, SUM("Total_Sales") as y
   FROM "Sales_Total" as ST left join "Dim_Date" as DD on ST."Sales Date Key" = DD."Date Key"
   GROUP BY ds';
   if($result = pg_query($db, $query)){
      $data= pg_fetch_all($result);
      //$data=json_encode($data);
   }
   else{
      echo pg_last_error($db);
      exit;
   }


   $url="https://forecastesales.herokuapp.com/sendjson2/";
   print_r(http_post_data($url, $data));


   
   // $curl = curl_init($url);
   // curl_setopt($curl, CURLOPT_HEADER, false);
   // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   // curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
   // curl_setopt($curl, CURLOPT_POST, true);
   // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
   // curl_setopt($curl, CURLOPT_URL, $url);
   // curl_exec($curl);
   
   // echo json_decode(file_get_contents('php://input','r'), true);

   // curl_close($curl);
?>
