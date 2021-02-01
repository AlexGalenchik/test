<?php
include_once('../config.php');
include_once('../functions.php');
session_start();

//echo "<pre>";
//var_dump($_SESSION);
//echo "</pre>";

unset($_SESSION['adsearch']);
unset($_SESSION['reg']);
unset($_SESSION['Areas']);
unset($_SESSION['type_dogovor']);
unset($_SESSION['search_bs']);
unset($_SESSION['type_bs']);
unset($_SESSION['start_date_1']);
unset($_SESSION['start_date_2']);
unset($_SESSION['start_date_3']);
unset($_SESSION['start_date_4']);
unset($_SESSION['type_currency']);
unset($_SESSION['arendodatel']);
unset($_SESSION['summa_rent']);
unset($_SESSION['num_rent']);
unset($_SESSION['more_equal']);
unset($_SESSION['woker']);
unset($_SESSION['city']);
unset($_SESSION['departament']);
unset($_SESSION['data_dog']);
unset($_SESSION['division']);
unset($_SESSION['type_bs']);


unset($_POST['adsearch']);
unset($_POST['reg']);
unset($_POST['Areas']);
unset($_POST['type_dogovor']);
unset($_POST['search_bs']);
unset($_POST['type_bs']);
unset($_POST['start_date_1']);
unset($_POST['start_date_2']);
unset($_POST['start_date_3']);
unset($_POST['start_date_4']);
unset($_POST['type_currency']);
unset($_POST['arendodatel']);
unset($_POST['summa_rent']);
unset($_POST['num_rent']);
unset($_POST['more_equal']);
unset($_POST['woker']);
unset($_POST['city']);
unset($_POST['departament']);
unset($_POST['data_dog']);
unset($_POST['division']);
unset($_POST['type_bs']);





//echo "<pre>";
//var_dump($_SESSION);
//echo "</pre>";



//var_dump($_POST['Region']);
//foreach ($_POST as $key => $value) {
//    echo "<pre>";
//    var_dump($key);
//    echo "</pre>";
//}


// Возврат на предыдущую страницу edit.php, в которой происходило редактирование
echo "<html><head><meta http-equiv='Refresh' content='0; URL=".'geo_finder.php'."'></head></html>";
//echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";




