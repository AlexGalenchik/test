<?php
include_once('../config.php');
include_once('../functions.php');
session_start();

function clean($value = "") {
	$value = trim($value); //Убирает пробелы в начале и в конце записи
	$value = stripslashes($value); //Убирает экранирование символов
	$value = strip_tags($value);// Удаляет теги HTML и PHP из строки
	$value = htmlspecialchars($value,ENT_QUOTES,'cp1251'); //Преобразует специальные символы в HTML-сущности
	return $value;
}

// Функция избавления от нулей в таблице rent при пустых значениях или нулях в POST
function no_zero ($post,$field) {
		$post = str_replace(",",".",$post);
		
	If (empty($post) || $post == 0 || $post == '') {
			
				$field = NULL;
			} else {
				$field = str_replace(",",".",$post);
			}
			return $field;
}
// Функция избавления от нулей в таблице rent при пустых значениях или нулях в POST
function no_zero_data ($post,$field) {
				
	If (empty($post) || $post == '0000-00-00' || $post == '') {
				$field = NULL;
			} else {
				$field = $post;
			}
			return $field;
}

function quotes_change ($text) {  //Функция перевода ковычек из верхних в нижние
	$text = str_replace(' "',' «',$text);
	$right_text = str_replace('"','»',$text);
	
	return $right_text;
}

$id = $_GET['Id'];

//получаем переменные из всех ячеек

if ((isset($_POST['bts']) && !empty($_POST['bts']) ) ) {
			$bts = $_POST['bts'];
			$bts = clean($bts);
}
			// Параметры NE (Обьект сети)
			$type_opori = $_POST['type_opori']; ////
			$oblast = $_POST['oblast'];   ////
			$raion = $_POST['raion'];   ////
	 		$nas_punkt = $_POST['nas_punkt']; ////
			$adress = quotes_change ($_POST['adress']); ///////////////////New
			
			$type_opori = clean($type_opori); ////
			$oblast = clean($oblast);   ////
			$raion = clean($raion);     ////
			$nas_punkt = clean($nas_punkt); /////
			$adress = clean($adress); ///////////////////New
						
			// Параметры земельного участка (ЗУ)
			$svidetelstvo_land = $_POST['svidetelstvo_land']; ////
			$svidetelstvo_land_date = no_zero_data($_POST['svidetelstvo_land_date'],$svidetelstvo_land_date); ///////////////////New
			$kadastroviy_number = $_POST['kadastroviy_number']; ////
			$land_area = no_zero ($_POST['land_area'],$land_area); ////
			$type_rent = $_POST['type_rent']; ////
			//$resheniye_videlenie = $_POST['resheniye_videlenie']; //Поле стало не нужным 24.12.2020
			//$resheniye_videlenie_date = no_zero_data ($_POST['resheniye_videlenie_date'],$resheniye_videlenie_date); ///////////////////New
			
			$svidetelstvo_land = clean($svidetelstvo_land); ////
			$kadastroviy_number = clean($kadastroviy_number); ////
			$type_rent = clean($type_rent); ////
			//$resheniye_videlenie = clean($resheniye_videlenie); // //Поле стало не нужным 24.12.2020
			//$resheniye_videlenie_date = clean($resheniye_videlenie_date); //Поле стало не нужным 24.12.2020
			
			//Арендная плата BYN, USD
			$rent_BYN = no_zero ($_POST['rent_BYN'],$rent_BYN);
			$rent_USD = no_zero ($_POST['rent_USD'],$rent_USD);
									
			//$rent_USD = clean ($rent_USD);
			//$rent_BYN = clean($rent_BYN);
			
			// Параметры Договора
			$dogovor_number = $_POST['dogovor_number'];
			$dogovor_date = no_zero_data ($_POST['dogovor_date'],$dogovor_date);
			$dogovor_start = no_zero_data ($_POST['dogovor_start'],$dogovor_start); ///////////////////New
			$dogovor_finish = no_zero_data ($_POST['dogovor_finish'],$dogovor_finish); ///////////////////New
			
			$dogovor_number = clean($dogovor_number);
					
            //Документы на Строение
			$inventarniy_building = $_POST['inventarniy_building'];
			$svidetelstvo_building = $_POST['svidetelstvo_building'];
			$svidetelstvo_building_date = no_zero_data ($_POST['svidetelstvo_building_date'],$svidetelstvo_building_date); ///////////////////New
			
			$inventarniy_building = clean($inventarniy_building);
			$svidetelstvo_building = clean($svidetelstvo_building);
						
			//Разрешение на строительство
			//$razreshenie_number = $_POST['razreshenie_number'];  ///////////////////New
			//$razreshenie_number_date = no_zero_data ($_POST['razreshenie_number_date'],$razreshenie_number_date); ///////////////////New
			
			//$razreshenie_number = clean($razreshenie_number); ///////////////////New
						
			//Примечания
			$notes = quotes_change ($_POST['notes']);  ///////////////////New
			$notes = clean($notes); ///////////////////New
			
			//$ispolnitel = $_POST['ispolnitel'];
			
			
			
			///////////////////////////////////////СОХРАНЕНИЕ в ИСТОРИЮ///////////////////////////////////////
			
			 //Поверка наличия введенного типа валюты


			$data = array ( //массив данных поста, которые были исправлены
								 'Id' => $id
								,'bts' => $bts
								,'oblast' => $oblast
								,'raion' => $raion
								,'nas_punkt' => $nas_punkt
								,'adress' => $adress
								,'svidetelstvo_land' => $svidetelstvo_land
								,'svidetelstvo_land_date' => $svidetelstvo_land_date
								,'kadastroviy_number' => $kadastroviy_number
								,'land_area' => $land_area
								,'type_rent' => $type_rent
								,'rent_BYN' => $rent_BYN
								,'rent_USD' => $rent_USD
								,'inventarniy_building' => $inventarniy_building
								,'svidetelstvo_building' => $svidetelstvo_building
								,'svidetelstvo_building_date' => $svidetelstvo_building_date
								,'dogovor_number' => $dogovor_number
								,'dogovor_date' => $dogovor_date
								,'dogovor_start' => $dogovor_start
								,'dogovor_finish' => $dogovor_finish
								//,'resheniye_videlenie' => $resheniye_videlenie  			// Поля стали не нужны
								//,'resheniye_videlenie_date' => $resheniye_videlenie_date  // Поля стали не нужны
								//,'razreshenie_number' => $razreshenie_number  			// Поля стали не нужны
								//,'razreshenie_number_date' => $razreshenie_number_date  	// Поля стали не нужны
								,'type_opori' => $type_opori
								,'notes' => $notes
								
										
							);
							///Новый массив для русских имен
							$names = array ( 
								 'bts' => 'Номер Объекта'
								,'oblast' => 'Область'
								,'raion' => 'Район'
								,'nas_punkt' => 'Нас. пункт'
								,'adress' => 'Адрес'
								,'svidetelstvo_land' => 'Свид-во о гос. рег. ЗУ'
								,'svidetelstvo_land_date' => 'Дата Свид-ва о гос. рег. ЗУ'
								,'kadastroviy_number' => 'Кадастровый номер ЗУ'
								,'land_area' => 'Площадь ЗУ'
								,'type_rent' => 'Тип Договора'
								,'rent_BYN' => 'Годовая АП (BYN)'
								,'rent_USD' => 'Годовая АП (USD)'
								,'inventarniy_building' => 'Инвент. номер кап. стр-я'
								,'svidetelstvo_building' => 'Cвид-во о гос рег. кап. стр-я'
								,'svidetelstvo_building_date' => 'Дата Cвид-ва о гос рег. кап. стр-я'
								,'dogovor_number' => 'Номер договора аренды'
								,'dogovor_date' => 'Дата договора аренды'
								,'dogovor_start' => 'Дата начала действия договора'
								,'dogovor_finish' => 'Дата окончания действия договора'
								,'resheniye_videlenie' => 'Решение о выделении ЗУ'
								,'resheniye_videlenie_date' => 'Дата Решения о выделении ЗУ'
								,'razreshenie_number' => 'Номер Решения о разр-ии, СМР'
								,'razreshenie_number_date' => 'Дата Решения о разр-ии, СМР'
								,'type_opori' => 'Тип опоры'
								,'notes' => 'Примечания'
															
										
							);
							
	If ($_POST['NewButton'] == 'СОХРАНИТЬ') {						
											
							$id = MySQLActionRENT($data,'land_docs_minsk',$id,'update','history_land',$names,'ИЗМЕНЕНИЕ ДАННЫХ');

/////////////////////////////////КОНЕЦ СОХРАНЕНИЯ В ИСТОРИЮ//////////////////////////////////////////


//Проверка на выполнение функции
	If ($id) {
				echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";	
				echo "<center><b>СОХРАНЕНО!</b></center>";
				// Возврат на предыдущую страницу edit.php, в которой происходило редактирование
				echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";
				
	} else {
				echo "<center><img src=\"../pics/_decline_pic.png\" width=\"100px\"></center>";			
				echo '<p>Произошла ошибка: ' . mysql_error(). '</p>';
	}	
}
?>

		 





 