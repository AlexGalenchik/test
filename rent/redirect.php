<?php
//RENT_EDITOR
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

$id = $_GET['Id'];

Function quotes_change ($text) {  //Функция перевода ковычек из верхних в нижние
	$text = str_replace(' "',' «',$text);
	$right_text = str_replace('"','»',$text);
	
	return $right_text;
}

//получаем переменные

if ( (isset($_POST['numBS_MTS']) && !empty($_POST['numBS_MTS']) ) ) {
	
			$numBS_MTS = $_POST['numBS_MTS']; 		//Номер объекта
			$numBS_MTS = clean($numBS_MTS);
}
			$region = $_POST['region']; 				//Область
			$area = $_POST['area'];						//Район
	 		$type_arenda = $_POST['type_arenda'];   	//Тип аренды
			$type = $_POST['type'];                 	//Тип NE
			$adress = quotes_change($_POST['adress']);  //Адрес
			$settlement = $_POST['settlement'];     	//Населенный пункт

			$region = clean($region); //Очистка блока переменных фнкцией Clean (в начале кода)
			$area = clean($area);
			$type_arenda = clean($type_arenda);
			$type = clean($type);
			$adress = clean($adress);
			$settlement = clean($settlement);
            //////////////////////////////////////////////////////////////
			//Площадь помещения (числовое)
			$room = no_zero($_POST['room'],$room); 
			
			//Площадь кровли (числовое)
			$roof_walls = no_zero ($_POST['roof_walls'],$roof_walls);
			
			//Площадь асфальтной площадки (числовое)
			$asfalt_square = no_zero ($_POST['asfalt_square'],$asfalt_square);
			
			//Длина кабеля (числовое)
			$cabel = no_zero ($_POST['cabel'],$cabel);
			
			//Длина канализации (числовое)
			$canalization = no_zero($_POST['canalization'],$canalization);
			
			$room = clean($room); //Очистка блока переменных фнкцией Clean (в начале кода)
			$roof_walls = clean($roof_walls);
			$asfalt_square = clean($asfalt_square);
			$cabel = clean($cabel);
			$canalization = clean($canalization);
			////////////////////////////////////////////////////////////
			If (!empty($_POST['arendodatel'])) {
			$arendodatel = quotes_change ($_POST['arendodatel']);//Исправление кавычек с верхних на нижние
			}
			$arendator = quotes_change ($_POST['arendator']);	//Исправление кавычек с верхних на нижние
			$num_dogovor = $_POST['num_dogovor'];		//Номер Договора (тектовое)
			$type_dogovor = $_POST['type_dogovor'];		//Тип Договора (тектовое)
			$data_dogovor = no_zero_data ($_POST['data_dogovor'],$data_dogovor);		//Дата договора (дата)
			$start_dogovor = no_zero_data ($_POST['start_dogovor'],$start_dogovor);	//Дата начала договора (дата)
			$finish_dogovor = no_zero_data ($_POST['finish_dogovor'],$finish_dogovor); //Дата окончания договора (дата)
			$finish_strah = no_zero_data ($_POST['finish_strah'],$finish_strah); //Дата окончания страховки (дата)
			$prolongaciya = $_POST['prolongaciya']; //Пролонгация (продление автоматом) договора
									
			$arendodatel = clean($arendodatel); //Очистка блока переменных фнкцией Clean (в начале кода)
			$arendator = clean($arendator);
			$num_dogovor = clean($num_dogovor);
			$type_dogovor = clean($type_dogovor);
			$data_dogovor = clean($data_dogovor);
			$start_dogovor = clean($start_dogovor);
			$finish_dogovor = clean($finish_dogovor);
			$finish_strah = clean($finish_strah);
			$prolongaciya = clean ($prolongaciya); //Пролонгация
			/////////////////////////////////////////////////////////////////
			$ako_exist = $_POST['ako_exist'];        //Договор АКО (да/нет)
			$ako_exist = clean($ako_exist);
			
			//$ako_reason = $_POST['ako_reason']; Поле не используется для заполнения в форме и вывода в карточке
			//$ako_reason = clean($ako_reason);  Поле не используется для заполнения в форме и вывода в карточке
			
			////////////////////////////////////////////////////////////////
			$pud = $_POST['pud'];                 		  // Наличие ПУД (да/нет)
			$form_own = $_POST['form_own'];		  		  //Форма собственности (гос./не гос.)
			$method_AP = $_POST['method_AP'];     		  //Метод формирования Арендной платы (старвки/согл. сторон/ставки + согл. сторон)
			
			
			$main_person = $_POST['main_person']; 		  //Ответственное лицо (тектовое)
			$notes = quotes_change ($_POST['notes']); 	  //Примечания (текстовое)
			$contact = quotes_change ($_POST['contact']); //Контактная информация (текстовое)
			$post_adres = $_POST['post_adres']; //Почтовый адрес (текстовое)
			
			$pud = clean($pud);					//Очистка блока переменных фнкцией Clean (в начале кода)
			//$form_own = clean($form_own);
			//$method_AP = clean($method_AP);
			$main_person = clean($main_person);
			$notes = clean($notes);
			$contact = clean($contact);
			$post_adres = clean ($post_adres);
			/////////////////////////ОФИСЫ и СКЛАДЫ///////////////////////////////////
			$proverka_contragenta = $_POST['proverka_contragenta']; 				//Проверка контрагента (вместо поля naznachenie)
			$data_proverki = $_POST['data_proverki'];
			
			//Площадь административного офиса (число)
			$admin_office = no_zero ($_POST['admin_office'],$admin_office);
 			
			//Площадь офиса продаж (число)
			$sell_office = no_zero($_POST['sell_office'],$sell_office);				
			
			//Площадь технического офиса (число)
			$tech_office = no_zero ($_POST['tech_office'],$tech_office);				
			
			//Площадь складов (число)
			$sklady = no_zero($_POST['sklady'],$sklady);

			//Площадь Архивов (число)
			$arhiv = no_zero($_POST['arhiv'],$arhiv);			
			
			///////////////////////////////////////////////////////////////////////////////
			//$payment = $_POST['payment'] ;   //// Поле не используется и ф форме карточки его уже нет
			//$currency = $_POST['currency'];  //// Поле не используется и ф форме карточки его уже нет
			//$type_rent_propety = $_POST['type_rent_propety']; //Тип арендуемого имущества (Исключено из таблицы)

			$proverka_contragenta = clean($proverka_contragenta); 
			$data_proverki = clean($data_proverki); 
			$admin_office = clean($admin_office);
			$sell_office = clean($sell_office);
			$tech_office = clean($tech_office);
			$sklady = clean($sklady);
			$arhiv = clean($arhiv);
			//$payment = clean($payment);   Поле не используется и ф форме карточки его уже нет
			//$currency = clean($currency); Поле не используется и ф форме карточки его уже нет
			//$type_rent_propety = clean($type_rent_propety); //Тип арендуемого имущества (Исключено из таблицы)

			$type_opory = $_POST['type_opory'];                       //Тип опоры имущества, сдаваемого в аренду
			$rent_place_TSH = $_POST['rent_place_TSH'];               //Аренда места в телекомм. шкафу (текстовое)
			$rent_area = $_POST['rent_area'];						  //Площадь, сдаваемая в аренду (текстовое)
			$division = $_POST['division'];							  //Подразделение	
			$svidetelctvo_regist = $_POST['svidetelctvo_regist'];	  //Свидетельство о регистрации (текстовое)

			$type_opory = clean($type_opory);
			$rent_place_TSH = clean($rent_place_TSH);
			$rent_area = clean($rent_area);
			$svidetelctvo_regist = clean($svidetelctvo_regist);

			// получаем из селекта тип валюты и сумму и НДС
			$summa = no_zero ($_POST['summa'],$summa);
			$type_currency = $_POST['type_currency'] ;
			$nds2 = no_zero ($_POST['nds2'],$nds2);
			$nds = $nds2 ;
			
			$summa = clean($summa);  //Очистка блока переменных фнкцией Clean (в начале кода)
			$type_currency = clean($type_currency);
			$nds2 = clean($nds2);
			$nds = clean($nds);
			
			//Запись значений в переменные в зависимости от выбранного типа валюты	

			if($type_currency=="BYN") {
				$byn = $summa;
				$bav = NULL;  //NULL дописано - Галенчик А.В. 03.12.2020 везде
				$bv  = NULL;
				$eur = NULL;
				$usd = NULL;
			}
			if($type_currency=="БАВ") {
				$byn = NULL;
				$bav = $summa;
				$bv  = NULL;
				$eur = NULL;
				$usd = NULL;
			}
			if($type_currency=="БВ") {
				$byn = NULL; 
				$bav = NULL;
				$bv  = $summa;
				$eur = NULL;
				$usd = NULL;
			}
			if($type_currency=="EUR") {
				$byn = NULL; 
				$bav = NULL;
				$bv  = NULL;
				$eur = $summa;
				$usd = NULL;
			}
			if($type_currency=="USD") {
				$byn = NULL; 
				$bav = NULL;
				$bv  = NULL;
				$eur = NULL;
				$usd = $summa;
			}

			$byn = clean($byn);
			$bav = clean($bav);
			$bv = clean($bv);
			$eur = clean($eur);
			$usd = clean($usd);
			
			///////////////////////////////////////СОХРАНЕНИЕ в ИСТОРИЮ///////////////////////////////////////
			
			


/*
If ($_POST['type_currency'] !== '') 		{
				if($_POST['type_currency']=="BYN") {
				$byn_history = $_POST['summa'];
				$bav_history = '';
				$bv_history = '';
				$eur_history = '';
				$usd_history = '';
				}
				if($_POST['type_currency']=="БАВ") {
				$byn_history = '';
				$bav_history = $_POST['summa'];
				$bv_history = '';
				$eur_history = '';
				$usd_history = '';
				}
				if($_POST['type_currency']=="БВ") {
				$byn_history = '';
				$bav_history = '';
				$bv_history =  $_POST['summa'];
				$eur_history = '';
				$usd_history = '';
				}
				if($_POST['type_currency']=="EUR") {
				$byn_history = '';
				$bav_history = '';
				$bv_history =  '';
				$eur_history = $_POST['summa'];
				$usd_history = '';
				}
				if($_POST['type_currency']=="USD") {
				$byn_history = '';
				$bav_history = '';
				$bv_history =  '';
				$eur_history = '';
				$usd_history =  $_POST['summa'];
				}
			} else {
				if($type_currency=="BYN") {
				$byn_history = $byn;
				}
				if($type_currency=="БАВ") {
				$bav_history = $bav;
				}
				if($type_currency=="БВ") {
				$bv_history = $bv;
				}
				if($type_currency=="EUR") {
				$eur_history = $eur;
				}
				if($type_currency=="USD") {
				$usd_history = $usd;
				}
			}
*/
			
			$data = array ( //массив данных поста, которые были исправлены
								'Id' => $id
								,'type_arenda' => $type_arenda
								,'type' => $type				
								,'number' => $numBS_MTS
								,'region' => $region			
								,'area' => $area				
								,'settlement' => $settlement			
								,'adress' => $adress			
								,'arendodatel' => $arendodatel		
								,'arendator' => $arendator
								,'dogovor_number' => $num_dogovor		
								,'dogovor_type' => $type_dogovor		
								,'dogovor_date' => $data_dogovor		
								,'start_date_dogovor' => $start_dogovor
								,'finish_date_dogovor' => $finish_dogovor
								,'prolongaciya' => $prolongaciya     // Пролонгация (пробление договора (Да/Нет))								
								,'admin_office' => $admin_office	
								,'sell_office' => $sell_office		
								,'tech_office' => $tech_office	
								,'sklady' => $sklady
								,'arhiv' => $arhiv
//								,'payment' => $payment	// пока это поле не задействовано и в таблице не используется			
//								,'currency' => $currency  // пока это поле не задействовано и в таблице не используется			
								,'type_opory' => $type_opory
								,'rent_place_TSH' => $rent_place_TSH 
								,'rent_area' => $rent_area				
								,'room_area' => $room			
								,'roof_area' => $roof_walls 		
								,'asphalt_pad_area' => $asfalt_square 
								,'length_cable' => $cabel				
								,'length_canaliz' => $canalization
								,'rent_pay_BYN' => $byn
								,'rent_pay_BAV' => $bav
								,'rent_pay_BV' => $bv
								,'rent_pay_EUR' => $eur
								,'rent_pay_USD' => $usd
								,'nds_pay' => $nds
								,'proverka_contragenta' => $proverka_contragenta //Новое поле вместо неиспользуемого поля naznachenie
								,'data_proverki' => $data_proverki //Новое поле 									
								,'ispolnitel' => $main_person 
								,'notes' => $notes
								,'contragent_data' => $contact
								,'post_adres' => $post_adres            // Добавлен почтовый адрес по запросу филиала
								,'insurance_finish' => $finish_strah
//								,'number_of_dogovors' => 1  	              	 Поле не используется для заполнения в форме и вывода в карточке
								,'dogovor_AKO' => $ako_exist 
								,'PUD' => $pud 							
//								,'prichiny_AKO' => $ako_reason       		     Поле не используется для заполнения в форме и вывода в карточке	
								,'own_form' => $form_own  				
								,'method_form_AP' => $method_AP   		
								,'summa' => $summa
								,'type_currency' => $type_currency
								,'nds2' => $nds2
								,'division' => $division
								,'svidetelctvo_regist' => $svidetelctvo_regist  
										
							);
							///Новый массив для русских имен
							$names = array ( 
								'type_arenda' => 'Тип аренды'
								,'type' => 'Тип объекта'				
								,'number' => 'Номер объекта'
								,'region' => 'Область'			
								,'area' => 'Район'				
								,'settlement' => 'Нас. пункт'			
								,'adress' => 'Адрес'			
								,'arendodatel' => 'Арендодатель'		
								,'arendator' => 'Арендатор'
								,'dogovor_number' => 'Номер договора'		
								,'dogovor_type' => 'Тип договора'		
								,'dogovor_date' => 'Дата договора'		
								,'start_date_dogovor' => 'Дата начала Договора'	
								,'finish_date_dogovor' => 'Дата окончания договора'
								,'prolongaciya' => 'Пролонгация договора'								
								,'admin_office' => 'Административный офис'	
								,'sell_office' => 'Офис продаж'		
								,'tech_office' => 'Технический офис'	
								,'sklady' => 'Склад'
								,'arhiv' => 'Архив'
								,'payment' => 'Платежи'			
								,'currency' => 'Валюта'			
								,'type_opory' => 'Тип опоры'
								,'rent_place_TSH' => 'Арендная плата' 
								,'rent_area' => 'Площадь аренды'				
								,'room_area' => 'Площадь помещения'  			
								,'roof_area' => 'Площадь кровли' 		
								,'asphalt_pad_area' => 'Площадь асфальта' 
								,'length_cable' => 'Длина кабеля'				
								,'length_canaliz' => 'Длина кабельной кан-ии'
								,'rent_pay_BYN' => 'Платежи за аренду (BYN)'
								,'rent_pay_BAV' => 'Платежи за аренду (БАВ)'
								,'rent_pay_BV' => 'Платежи за аренду (БВ)'
								,'rent_pay_EUR' => 'Платежи за аренду (EUR)'
								,'rent_pay_USD' => 'Платежи за аренду (USD)'
								,'nds_pay' => 'Платежи НДС'
								,'proverka_contragenta' => 'Проверка контрагента'
								,'data_proverki' => 'Дата проверки'								
								,'ispolnitel' => 'Исполнитель' 
								,'notes' => 'Примечания' 
								,'contragent_data' => 'Контактное лицо'
								,'post_adres' => 'Почтовый адрес'								
								,'insurance_finish' => 'Дата окончания страхования'
								,'number_of_dogovors' => 'Количество договоров'	
								,'dogovor_AKO' => 'Договор АКО' 
								,'PUD' => 'ПУД' 							
								,'prichiny_AKO' => 'Причины АКО'			
								,'own_form' => 'Форма собственности'  				
								,'method_form_AP' => 'Метод формирования АП'   		
								,'summa' => 'Сумма платежа'
								,'type_currency' => 'Тип Валюты'
								,'nds2' => 'Платеж НДС' 
								,'division' => 'Подразделение'
								,'svidetelctvo_regist' => 'Свидетельство о Регистрации'  
										
							);
							
If ($_POST['NewButton'] == 'СОХРАНИТЬ') {
								
	$id = MySQLActionRENT($data,'rent',$id,'update','history_rent',$names,'ИЗМЕНЕНИЕ ДАННЫХ'); //Фнкция обновляетданные в таблице rent и записывает в историю
	
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



/*
If ($_POST['NewButton'] == 'СОХРАНИТЬ') {	//Если была нажата кнопка СОХРАНИТЬ в форме Редактирования

		//Запрос на обновление данных из массива POST в таблицу
		
		$sql = "UPDATE `rent` SET 
			`region` = '".$region."',
			`area` = '".$area."',
			`number` = '".$numBS_MTS."',
			`type_arenda` = '".$type_arenda."',
			`type` = '".$type."',
			`adress` = '".$adress."',
			`settlement` = '".$settlement."',
 
 			`room_area` = '".$room."',
			`roof_area` = '".$roof_walls."',
			`asphalt_pad_area` = '".$asfalt_square."',
			`length_cable` = '".$cabel."',
			`length_canaliz` = '".$canalization."',
			`arendodatel` = '".$arendodatel."',
			`arendator` = '".$arendator."',
 			
			`dogovor_number` = '".$num_dogovor."',
			`dogovor_type` = '".$type_dogovor."',
			`dogovor_date` = '".$data_dogovor."',
			`start_date_dogovor` = '".$start_dogovor."',
			`finish_date_dogovor` = '".$finish_dogovor."',
			`insurance_finish` = '".$finish_strah."',
			 
			`dogovor_AKO` = '".$ako_exist."',
			
 			`PUD` = '".$pud."',
			`own_form` = '".$form_own."',
			`method_form_AP` = '".$method_AP."',
			`ispolnitel` = '".$main_person."',
			`notes` = '".$notes."',
			`contragent_data` = '".$contact."',
			`naznachenie` = '".$naznachenie."',
 			
			`admin_office` = '".$admin_office."',
			`sell_office` = '".$sell_office."',
			`tech_office` = '".$tech_office."',
			`sklady` = '".$sklady."',
			`payment` = '".$payment."',
			`currency` = '".$currency."',
			`type_rent_propety` = '".$type_rent_propety."',
  
			`type_opory` = '".$type_opory."',
			`rent_place_TSH` = '".$rent_place_TSH."',
			`rent_area` = '".$rent_area."',
			 
			`rent_pay_BYN` = '".$byn."',
 			`rent_pay_BAV` = '".$bav."',
			`rent_pay_BV` = '".$bv."',
			`rent_pay_EUR` = '".$eur."',
			`rent_pay_USD` = '".$usd."',
			`nds_pay` = '".$nds."',
			
			`summa` = '".$summa."',
			`type_currency` = '".$type_currency."',
			`nds2` = '".$nds2."',
			`division` = '".$division."',
			`svidetelctvo_regist` = '".$svidetelctvo_regist."'
 	 
			 WHERE `Id` = ".$_GET['Id'];
		     $query = mysql_query($sql) or die(mysql_error());

		if ($sql) {
					echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";	
					echo "<center><b>СОХРАНЕНО!</b></center>";
					}	

					// Возврат на предыдущую страницу edit.php, в которой происходило редактирование
						echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'></head></html>";

} else {
		echo "<center><img src=\"../pics/_decline_pic.png\" width=\"100px\"></center>";			
		echo '<p>Произошла ошибка: ' . mysql_error(). '</p>';
}
*/
		
		
		 


?>


 