<?php
 include_once('config.php'); //Подключение к Базе данных
 
 //echo "<pre>"; 
 //print_r($_SESSION);
 //echo "</pre>";
 
 $onlinelogin = $_SESSION['user_login'];
 
 
 $sql  = " UPDATE `users` SET `last_activity` = UNIX_TIMESTAMP()";
 $sql .= " WHERE UNIX_TIMESTAMP() - UNIX_TIMESTAMP(`last_activity`) > 86400 * 7";

$sql  = "SELECT * FROM `users`"; 
$sql .= " WHERE UNIX_TIMESTAMP() - `last_activity` > 3600 * 5";
$query = mysql_query($sql) or die(mysql_error());

if (mysql_num_rows($query)>0) {
    echo "<table id='result_table'>";
  for ($i=0; $i<mysql_num_rows($query); $i++) {
    $row = mysql_fetch_array($query);
    echo "<tr><td id='rs_td'>".$row['surname']."</td></tr>";
  } 
  echo "</table>";
}
?> 
