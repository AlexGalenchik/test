<?php
header('Content-Type: text/html; charset=utf-8');
include_once('./core/config.php');
include_once('./core/function.php');
include_once('../config.php');
session_start();

$id = $_SESSION['id_dog'];

$user = $_SESSION['user_id']; // ���������� ID ������������, ������� ����� �� �����

$region_user = $_SESSION['reg_user']; 

$sql_ispolnitel = " SELECT ispolnitel_id FROM land_docs_minsk WHERE id=$id ";
$query_ispolnitel = mysql_query($sql_ispolnitel) or die(mysql_error());
$row = mysql_fetch_array($query_ispolnitel);
$ispolnitel = $row['ispolnitel_id']; //������������ �� ������� rent

If (isset($id)) {

If ($_SESSION['reg_user'] == '�����') { //�������� �� ������. ����� ����� ������� ����� ������ � �����

			$sql = "DELETE FROM land_docs_minsk WHERE id=$id";
			$query = mysql_query($sql) or die(mysql_error());
			
		if ($sql) {
			
			echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
			echo "<center><b>".mb_convert_encoding('�������!','utf-8','cp1251')."</b></center>";
			}
		
} else {
		If ($ispolnitel == $user) { //�������� ������������ Id ������������ � Id ����������� ������
		
					$sql = "DELETE FROM land_docs_minsk WHERE id=$id";
					$query = mysql_query($sql) or die(mysql_error());
					
				If ($sql) {
					
					echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
					echo "<center><b>".mb_convert_encoding('�������!','utf-8','cp1251')."</b></center>";
				}	
		}  else 
				{
					
				echo "<center><img src=\"../pics/_decline_pic.png\" width=\"100px\"></center>";
				echo "<center><b>".mb_convert_encoding('� ��� ��� ����.','utf-8','cp1251')."<br/>".mb_convert_encoding('�� - �� ��������� �������','utf-8','cp1251')."</b></center>";
				}
	}	
}	

?>
<script>document.location.href="index.php"</script>