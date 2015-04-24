<?php
  // 自訂資料庫函式
  function db_affected_rows()     {return mysql_affected_rows(); }
  function db_data_seek($res, $num)
           {return mysql_data_seek($res, $num);}
  function db_error()             {return mysql_error();}
  function db_escape($param)      
           {return mysql_real_escape_string($param);}
  function db_fetch_array($res)   {return mysql_fetch_array($res);}
  function db_fetch_object($res)  {return mysql_fetch_object($res);}
  function db_insert_id($res)     {return mysql_insert_id($res);}
  function db_num_rows($res)      {return mysql_num_rows($res);}
  function db_query($sqlstr)      {return mysql_query($sqlstr);}

  // 將 GET 參數轉成同名變數, 例如 $_GET['abc'] => $abc
  if(count($_GET) > 0)
    foreach($_GET  as $k => $v)
      if(is_array($v))            // 若參數本身也是陣列
        foreach($v as $vk => $vv) // 則建立陣列變數
          ${$k}[$vk] = db_escape($vv);
      else $$k = db_escape($v);

  // 將 POST 參數轉成同名變數, 例如 $_POST['abc'] => $abc
  if(count($_POST) > 0)
    foreach($_POST as $k => $v)
      if(is_array($v)) 
        foreach($v as $vk => $vv) 
          ${$k}[$vk] = db_escape($vv);        
      else $$k = db_escape($v);
?>
