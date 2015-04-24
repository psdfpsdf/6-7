<?php
  define('TIME_SPAN', 1);   // 將限制時間設為 30 分鐘

  $voter_ip = $_SERVER['REMOTE_ADDR']; // 取得使用者 IP 位址
  //從資料庫中取出 30 分鐘內曾經投過票的 IP 位址
  $SQLStr = "SELECT * FROM voteuser WHERE v_id = '$v_id' " .
            "AND DATE_ADD(v_time, INTERVAL 1 MINUTE) > now()";
  $res = db_query($SQLStr);

  //抓取資料表中同ip的最新,加上指定時間若超過現在時間，就新增紀錄，反之不可重覆           
  // $SQLStr2 = "SELECT * FROM voteuser WHERE v_ip = '$voter_ip' ORDER BY v_time desc";
  // $res2 = db_query($SQLStr2);
  // $row  = db_fetch_array($res2);
  // $v_time = $row['v_time'];
  // echo $v_time;
  // $SQLStr = "SELECT * FROM voteuser WHERE v_id = '$v_id' AND v_ip = '$voter_ip' AND now() < DATE_ADD('$v_time', INTERVAL 1 MINUTE) ";
  // $res = db_query($SQLStr);
  echo mysql_error();


  if (db_num_rows($res)>0)  { // 若有符合上述條件的資料
    echo "<script>";
    echo "alert(\"您不可重複投票\");";
    echo "location.href = \"vote.php?v_id=" . $v_id . "\";";
    echo "</script>";
    exit(); // 執行中斷, 不再執行下述程式
  }
  else {
    // 將使用者的 IP 位置, 時間寫入資料庫中
    $SQLStr = "INSERT INTO voteuser (v_id, v_ip, v_time) ";
    $SQLStr .= "VALUES ('$v_id', '$voter_ip', now())";
    db_query($SQLStr);
  }
?>
