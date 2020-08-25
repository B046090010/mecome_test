<?php
if(isset($_GET['n'])) {
    $n = $_GET['n'];
  
    // 以外部指令的方式呼叫 R 進行繪圖
    exec("Rscript script.R $n");
  
}
?>