<?php 
// Форма ввода даты включения технологий

  
  $mysqli = new mysqli ("localhost", "root", "123", "mts_dbase");
  $mysqli->query ("SET NAMES 'utf8'");
  
  $date_gsm_on =  ($_POST['GSMon']); 
  echo 'Дата включения GSM :'.$date_gsm_on;

  $mysqli->query ("INSERT INTO `data_primer` (`Date_ON`) VALUES ('".$date_gsm_on."')");
  
  $mysqli->close ();
 


?>