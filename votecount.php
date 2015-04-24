<?php
  include_once('db_conn.php');
  include_once('db_func.php');
  
  header('Content-Type: text/html; charset=utf-8');
  include_once('ipcheck.php');      // 引用檢查 IP 位址模組
  if(!isset($t_id)) {   // 若表單未傳送 't_id' 參數
    header ('Location: vote.php');   // 回投票網頁
    exit();                          // 結束程式
  }

  // 將使用者選擇的投票選項之票數加一
  $SQLStr = "UPDATE vote SET t_count = t_count+1 " .
            "WHERE t_id = '$t_id'";
  @db_query($SQLStr);
?>
<script>
alert("感謝您的投票, 票數已計入");
location.href = "vote.php?v_id=<?php echo $v_id ?>";
</script>
