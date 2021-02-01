<?php
include_once('../config.php');
include_once('../functions.php');
session_start();

If ($_POST['NewButton'] == 'СОХРАНИТЬ') {	//Если была нажата кнопка СОХРАНИТЬ в форме Редактирования
	
	$temp_number_bs = $_POST['numBS_MTS'];
	If (strlen($temp_number_bs) == 1) {  //Добавление нулей в начало, если введен номер менее 100
		$temp_number_bs = '00'.(string)$temp_number_bs;
	}
	If (strlen($temp_number_bs) == 2) {
		$temp_number_bs = '0'.(string)$temp_number_bs;
	}
	If (strlen($temp_number_bs) == 3) {
		$temp_number_bs = (string)$temp_number_bs;
	}
	 

		If (!empty($_POST['type_arenda']) && !empty($_POST['numBS_MTS'])) {
			// Запрос на внесение данных в таблицу из формы
			$sql_new = " INSERT INTO `rent` (`type_arenda`,`type`,`number`,`number_rent`,`room_area`,`roof_area`,`asphalt_pad_area`,`rent_area`,`length_cable`,`length_canaliz`,
			`arendodatel`,`arendator`,`dogovor_number`,`dogovor_type`,`dogovor_date`,`start_date_dogovor`,`finish_date_dogovor`,`insurance_finish`,`rent_pay_BYN`,
			`rent_pay_BAV`,`rent_pay_BV`,`rent_pay_EUR`,`rent_pay_USD`,`nds_pay`,`dogovor_AKO`,`prichiny_AKO`,`PUD`,`own_form`,`method_form_AP`,`ispolnitel`,
			`contragent_data`,`post_adres`)";
			$sql_new.= "  VALUES  ";
			$sql_new.= " ('".$_POST['type_arenda']."','".$_POST['typeBS']."','".$temp_number_bs."','".$_POST['numBS_Arendodatel']."','".$_POST['room']."','".$_POST['roof_walls']."',
			'".$_POST['asfalt_square']."','".$_POST['rent_area']."','".$_POST['cabel']."','".$_POST['canalization']."','".$_POST['arendodatel']."','".$_POST['arendator']."',
			'".$_POST['num_dogovor']."','".$_POST['type_dogovor']."','".$_POST['data_dogovor']."','".$_POST['start_dogovor']."','".$_POST['finish_dogovor']."','".$_POST['finish_strah']."',
			'".$_POST['byn']."','".$_POST['bav']."','".$_POST['bv']."','".$_POST['eur']."','".$_POST['usd']."','".$_POST['nds']."','".$_POST['ako_exist']."','".$_POST['ako_reason']."',
			'".$_POST['pud']."','".$_POST['form_own']."','".$_POST['method_AP']."','".$_POST['main_person']."','".$_POST['contact']."','".$_POST['post_adres']."'
			)";
			$query5 = mysql_query($sql_new) or die(mysql_error());
			
			$_SESSION['bts_num'] = $_POST['numBS_MTS']; //Запись в сессию номера БС, для дальнейшего перехода к ней
			
			if ($sql_new) {
			echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";	
			echo "<center><b>СОХРАНЕНО!</b></center>";
			
			// Возврат на предыдущую страницу edit.php, в которой происходило редактирование
			echo "<html><head><meta http-equiv='Refresh' content='0; URL=\"/rent/index.php\"'></head></html>"; //.$_SERVER['HTTP_REFERER'].
				} else {
			echo "<center><img src=\"../pics/_decline_pic.png\" width=\"100px\"></center>";			
			echo '<p>Произошла ошибка: ' . mysql_error(). '</p>';
				}
		}
}
		
?>