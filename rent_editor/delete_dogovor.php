<?php
header('Content-Type: text/html; charset=utf-8');
include_once('./core/config.php');
include_once('./core/function.php');
include_once('../config.php');
session_start();

$id = $_SESSION['id_dog'];

$user = $_SESSION['user_id']; // Определяем ID пользователя, который сидит на сайте

$region_user = $_SESSION['reg_user']; 

$sql_ispolnitel = " SELECT ispolnitel_id FROM rent WHERE id=$id ";
$query_ispolnitel = mysql_query($sql_ispolnitel) or die(mysql_error());
$row = mysql_fetch_array($query_ispolnitel);
$ispolnitel = $row['ispolnitel_id']; //Вытягивается из таблицы rent

If (isset($id)) {

If (iconv('cp1251','utf-8',$_SESSION['reg_user']) == 'Админ') { //Проверка на Админа. Админ может удалить любую запись и чужую

			$sql = "DELETE FROM rent WHERE id=$id";
			$query = mysql_query($sql) or die(mysql_error());
			
		if ($sql) {
			
			echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
			echo "<center><b>УДАЛЕНО!</b></center>";
			}
		
} else {
		If ($ispolnitel == $user) { //Проверка соответствия Id пользователя и Id исполнителя записи
		
					$sql = "DELETE FROM rent WHERE id=$id";
					$query = mysql_query($sql) or die(mysql_error());
					
				If ($sql) {
					
					echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
					echo "<center><b>УДАЛЕНО!</b></center>";
				}	
		}  else 
				{
					
				echo "<center><img src=\"../pics/_decline_pic.png\" width=\"100px\"></center>";
				echo "<center><b>У ВАС НЕТ ПРАВ.<br/>ВЫ - НЕ СОЗДАТЕЛЬ ЗАПИСИ</b></center>";
				}
	}	
}	

?>
<script>document.location.href="geo_finder.php"</script>

	

	
	

	





