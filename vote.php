<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
  include_once('db_conn.php');//01
  include_once('db_func.php');

  if(!isset($v_id))  // 若 URL 中沒有 'v_id' 參數 
    $v_id = 1;       // 則將 $v_id 的值設為 1

  // 取出 votesubject 資料表中指定 (主題) 識別碼的資料
  $SQLStr = "SELECT * FROM votesubject WHERE v_id = '$v_id'";
  $res = db_query($SQLStr);

  // 取出 vote 資料表中指定 (主題) 識別碼的投票選項
  $SQLStr2 = "SELECT * FROM vote WHERE v_id = '$v_id'";
  $res2 = db_query($SQLStr2);

  if (db_num_rows($res) == 0 )  //檢查是否資料表中是否有資料
    exit();

  $row = db_fetch_array($res);
?>
<script>
  function result() {  // 以開啟新視窗顯示投票結果的 JavaScript 函式
    window.open("voteresult.php?v_id=<?php echo $v_id; ?>",
                "result",
                "width=540,height=240,status=0,scrollbars=0," +
                "resizable=1,menubar=0,toolbar=0,location=0");
  }
</script>
<form name="form1" method="post" action="votecount.php">
<table width="320" border="1" align="center" cellpadding="0">
<tr bgcolor="#FFFFCC">
  <th colspan="2" align="center">
      <?php echo $row['v_name']; ?>
  </th>
</tr>
  <?php
    $nums = db_num_rows($res2);

    // 用迴圈將每個投票項目輸出為表格中的一列
    for ($i=0;$i<$nums;$i++) {
      $option_row = db_fetch_array($res2);

      // 處理表格層次 BEGIN
      if (($i%2) == 0)                  // 利用是否被 2 整除
        echo "<tr bgcolor='#99CCFF'>";  // 將奇偶列設為不同背景顏色
      else
        echo "<tr>";

      echo "<td width='25' align='center'>";
      echo "<input type='radio' name='t_id' value='" .
           $option_row['t_id'] ."'></td>";
      echo "<td width='295'>" . $option_row['t_name'] . "</td></tr>";
    }
  ?>
<tr bgcolor="#FFFFCC">
  <td colspan="2">
    <div>
      <input type="hidden" name="v_id"
             value="<?php echo $row['v_id']?>">
      <input type="button" name="Submit"
             value="投票結果" onClick="result();">
      <input type="submit" name="Submit2" value="投票">
    </div>
  </td>
</tr>
</table>
</form>
