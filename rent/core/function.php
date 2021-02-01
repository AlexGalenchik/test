<?php
//выбор данных из таблицы в виде массива
function selectAll($conn){
    // получение данных из БД (выбираем все поля из rent кроме первого поля Id)!!!
    $sql = "SELECT type_arenda, type, number, region, area, settlement, adress, arendodatel, arendator, dogovor_number, dogovor_type, dogovor_date, start_date_dogovor, finish_date_dogovor,
    prolongaciya, admin_office, sell_office, tech_office, sklady, arhiv, type_opory, rent_place_TSH, rent_area, room_area, roof_area, asphalt_pad_area, length_cable, length_canaliz, 
    rent_pay_BYN, rent_pay_BAV, rent_pay_BV, rent_pay_EUR, rent_pay_USD, nds_pay, proverka_contragenta, data_proverki, ispolnitel, notes, contragent_data, post_adres, insurance_finish, 
	dogovor_AKO, PUD, prichiny_AKO, own_form, method_form_AP, summa, type_currency, nds2, division, svidetelctvo_regist  FROM  rent WHERE Id = ".$_GET['Id'];
	
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}

//функция отчистки
function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value,ENT_QUOTES,'cp1251');
    return $value;
}

//Счётчик пользователей онлайн
			function GetUsersOnline(){  
				clearstatcache();
				$SessionDir = session_save_path();
				$Timeout = 60 * 10; 
					if ($Handler = scandir ($SessionDir)){
						$count = count ($Handler);
						$users = 0;
     
						for ($i = 0; $i < $count; $i++){
							if (time() - fileatime ($SessionDir . '/' . $Handler[$i]) < $Timeout){
							$users++;
							}
						}
                         
						return $users;
					} else {
						return 'error';
					}
			}