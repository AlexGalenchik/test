<?php
include_once('./core/config.php');
include_once('./core/function.php');
include_once('../config.php');
include_once('../functions.php');
session_start();

//$Id = $_GET['Id'];

//  подключения к БД
  $conn = connect();
//выбор данных из таблицы в виде массива
  $dataAll = selectAll($conn); //core/functions.php
  
  //Для записи Id пользователя нужен его Id для сохранения в RENT
	if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
	}

  // массивы ключей и знчений - в идеале передалть в асоциативны  один больщой   массив
$arr_key=[];
$arr_value=[];

// запоняем массивы и объединяем
foreach ($dataAll[0] as $key => $value) {
     array_push($arr_key, $key);
     array_push($arr_value, $value);
}
$combine=array_combine($arr_key,$arr_value);
//echo "<pre>";
//print_r($combine);
//echo "</pre>";
/*  Не нужно вносить в таблицу rent, так как это вносит Фнкция MySQLActionRENT

    $sql = "INSERT INTO rent (";
                for ($i=1; $i < count($arr_key); $i++) {
                    $sql .= $arr_key[$i];
                    if($i<count($arr_key)-1) {
                        $sql .= ", ";
                    };
                };
            $sql .= ")  VALUES (";
                for ($i=1; $i < count($arr_value); $i++) {
                        $sql .= '"';
                        $sql .= $arr_value[$i];
                        $sql .= '"';
                        if($i < count($arr_value)-1) {
                            $sql .= ", ";
                        };
                    };
            $sql .=");";

// echo $sql;
 echo "<br>";
 echo "<br>";
 echo "<br>";

    $query = mysql_query($sql) or die(mysql_error());
	
*/	
    if ($combine) {

        echo "<center><img src=\"../pics/_signed_pic_.png\" width=\"100px\"></center>";
        echo "<center><b>КЛОНИРОВАНИЕ ЗАВЕРШЕНО!</b></center>";

    }



//$last_id = mysql_insert_id();  // Внутри функции MySQLActionRENT уже есть добавление Id нового, надо взять $id из Функции MySQLActionRENT, она выдает новый Id для типа Insert

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
								,'naznachenie' => 'Назначение' 			
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
								,'type_rent_propety' => 'Тип Арендуемого имущества'
								,'division' => 'Подразделение'
								,'svidetelctvo_regist' => 'Свидетельство о Регистрации'  
										
							);

$id = MySQLActionRENT($combine,'rent','','insert','history_rent',$names,'КЛОНИРОВАНИЕ'); //id не надо указывать в третьей позиции, так как это тип insert и внутри функции будет создан новый Id

$sql_isp_id = "UPDATE rent SET ispolnitel_id = $user_id WHERE Id = $id"; //Внесение Id исполнителя Договора в колонку Ispolnitel_id при клонировании
$query = mysql_query($sql_isp_id) or die(mysql_error());


// ,который и выдает функция (слева от равно в строке выше)
$new_url = 'edit.php?Id='.$id;
mysqli_close($conn);
?>

<script>
    var param = '<?php echo $new_url;?>';
   document.location.href=param
</script>


