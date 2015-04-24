<?php
  include_once('db_conn.php');
  include_once('db_func.php');

  if(!isset($v_id))  // 若 URL 中沒有 'v_id' 參數
    $v_id = 1;       // 則將 $v_id 的值設為 1

  // 計算屬於 $v_id 的所有選項所得的總票數
  $SQLSum = "SELECT SUM(t_count) from vote WHERE v_id = '$v_id'";
  $res = db_query($SQLSum);
  $row = db_fetch_array($res);
  $total_vote = $row[0];

  // 從 votesubject 資料表取得指定投票主題的名稱
  $SQLStr = "SELECT v_name FROM votesubject WHERE v_id = '$v_id'";
  $res = db_query($SQLStr);
  $row = db_fetch_array($res);
  $subject = $row[0];

  // 取出同一個投票主題的選項之資料
  $SQLStr = "SELECT * FROM vote WHERE v_id = '$v_id'";
  $res = db_query($SQLStr);
  // 取出同一個投票主題的選項資料 END

  if (db_num_rows($res) == 0) // 判斷查詢結果有無資料
    exit();                   // 若無資料則不繼續執行
?>
<html>
<head>
  <title>投票結果 - 圖形版</title>
  <meta http-equiv="Content-Type"
        content="text/html; charset=utf-8">
</head>
<body>
<table width="480" border="1" cellpadding="0" cellspacing="0" 
       align="center">
<tr bgcolor="#99CCFF">
  <th colspan="5"><b><?php echo $subject; ?></b></th>
</tr>
<tr bgcolor="#DDDDDD" align="center">
  <td colspan="2">題目</td>
  <td colspan="2">比例</td>
  <td width="50" >票數</td>
</tr>
<?php
  $num = db_num_rows($res);

  // 逐筆輸出每個選項的得票數
  for ($i=0;$i<$num;$i++) {
    $row = db_fetch_array($res);

    // 計算目前選項所佔的票數比例
    $share = floor(($row['t_count']/$total_vote)*100);

    // 決定所要使用的圖檔
    switch ($i%3) {
      case 0:
        $imgfile = 'bar_red.gif';  break;
      case 1:
        $imgfile = 'bar_green.gif';  break;
      case 2:
        $imgfile = 'bar_blue.gif';  break;
    }

    if (($i%2) == 0)       // 將奇偶列設為不同背景顏色
      echo "<tr bgcolor='#99CCFF'>";
    else
      echo "<tr>\n";

    echo "<td align='center'>" . $row['t_id'] . "</td>\n";
    echo "<td>" . $row['t_name'] . "</td>\n";

    // 輸出圖案, 依票數比例設定圖寬
    echo "<td width='205' style='border-right:0'>" .
         "<img src='$imgfile' height='10' width='" .
         $share*2 . "'></td>\n";

    // 輸出百分比數字及得票數
    echo "<td width='40' align='center' style='border-left:0'>" .
          $share . "%</td>";
    echo "<td width='40' align='center'>" .
         $row['t_count'] . "</td>\n";

    echo "</tr>\n";
  }

  // 在表格最下方顯示總投票人次
  echo "<tr bgcolor='#DD0000'>" .
       "<td colspan='4' align='right'>總投票人數：</td>" .
       "<td align='center'>" . $total_vote . "</td></tr>\n";
?>
</table>
</body></html>
