<?php
include_once('/core/config.php');
include_once('/core/function.php');
include_once('../config.php');
session_start();

$conn = connect(); // Подключение к БД
 
 //Функция, которая формирует массив из уникальных значений номеров объектов
 Function make_array ($table,$column,$conn,$column3) {
	 
	$sql = "SELECT DISTINCT $column FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE  $column3 like 'МТС арендует'";
		}
		$sql .= " ORDER BY $column";
	 
	$query =  mysqli_query($conn, $sql);
	
	$a = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row[$column];
			
	}
	return $a; 
	 
}

 

//Функция формирует массив из уникальных значений БС с адресами
 Function make_array2 ($table,$column1,$column2, $conn, $column3) {
	 
	$sql = "SELECT DISTINCT $column1, $column2 FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE  $column3 like 'МТС арендует'";
		}
		$sql .= " ORDER BY $column1";
	 
	 
	$query =  mysqli_query($conn, $sql);
	
	$a = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i < mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[$row[$column1]] = $row[$column2];
 
			
	}
	return $a; 
	 
}

///////////////////////////////////////////////////////////////////
//Формирование массива номеров объектов из стороннего файла емкости

//Создаем массив уникальных номеров БС и таблицы емкости сети
$emkost = make_array ('emkost_seti','bts_number',$conn,'');

//Создаем массив уникальных номеров БС и адресов из емкости сети
$emkost2 = make_array2 ('emkost_seti','bts_number','adress',$conn,'');

//Создаем массив Подвижных БС из емкости сети
$emkost_PBS = [7001,7002,7004,8001,8002,8003,2000,2001,2002,2003,2004,2005,2006,2007];

//Формирование массива номеров объектов из БД RENT

$rent = make_array ('rent','number',$conn, 'type_arenda');

//Формирование массива номеров объектов БД ЗЕМЛИ

$land = make_array ('land_docs_minsk','bts',$conn,'');

//Массив $nedostatok содержит элементы массива из файла емкости, которые не вошли в БД rent и в БД Land и в массив Подвижный БС (ПБС не учитываем при сверке)

$nedostatok = array_diff($emkost,$rent,$land,$emkost_PBS);

$_SESSION['nedostatok'] = count($nedostatok); //Для вывода отчета по количеству найденных объектов
 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--         <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>НЕ НАЙДЕННЫЕ ОБЪЕКТЫ</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href=" bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href=" Style.css">
    <script defer src="script.js"></script>
	<style>
	table {
    width: 100%;
    display:block;
	overflow: auto;
	}
	thead {
    display: inline-block;
    width: 100%;
    height: 20px;
	}
	tbody {
    height: 800px;
    display: inline-block;
    width: 100%;
    overflow: auto;
	}
	</style>
</head>
<body>


<div id="cap" class="container mt-1" ><!-- шапка header-->
    <div class="row align-self-center" ><!-- row header-->
        <div class="col-12" > <!-- row col-12 -->
            <div  class="container" > <!-- 2 container -->
                <div class="row align-items-center"><!-- row 2 -->
                    <div class="col-md-3 push-9" >
					
                      
                    </div>


                    <div class="col-md-9 pull-3">
					
					 <div class="col-md-5 ">
                                        <a href="../main.php"><button type="button" class="btn btn-danger">НАЗАД</button></a>
										<?php IF ($_SESSION['user_login'] == 'alex' || $_SESSION['user_login'] == 'pusharov') {?>
											<a href="/rent/sent.php"><button type="button" class="btn btn-danger" title="договора со сроком окончания до 3 месяцев">Уведомление по E-mail</button></a>
										<?php } ?>
                                    </div>
					
                                        
									
					
					<h4>НЕ НАЙДЕННЫЕ ОБЪЕКТЫ В БАЗЕ - <?php echo count($nedostatok); ?> БС (Январь 2021г.)</h4>
				 
					
                        <div class="row align-items-center ">
                            <div class="col-md-3 push-1">
                                
                                 
									 
                            </div>
							
                        </div>
                    </div>
                </div>		
            </div> <!-- row 2 -->
        </div><!-- 2 container -->
    </div><!-- row col-12 -->
</div><!-- row header-->

<div id="addFilter" class="container" >
        <div class="row justify-content-end align-items-center" >
            <div class="col-12 order-last">
                <div class="row">
					
				</div>
            </div>
			
        </div>
       

        
    </div>

<?php 

 If (count($nedostatok)>0) {
        echo "<div  class=\"container\" >"; // Шапка таблицы
        echo "<div class=\"row tablerow\">";
$k=0;

echo "<table>";
echo "<tr>
	  <th class='num_naideno'><b>№<b></th>
	  <th class='bts_naideno'><b>Номер БС<b></th>
	  <th class='adress_naideno'>Адрес объекта</th>
	  <th class='reasons'>Причины<br/>отсутствия в БД</th>
	  <th class='meri'>Мероприятия<br/>для решения</th>
	  <th class='sroki'>Срок<br/>выполнения</th>
	  <th class='redactor'>Ответственный</th><tr>";
	 
	  
foreach($nedostatok as $value) {
	
	if(array_key_exists($value, $emkost2)) {
		$k++;
		// Поиск причин не внесения БС в таблице DELTA_INFO
		$sql = " SELECT `info`, `events`,`srok`,`ispolnitel` FROM `delta_info` WHERE `bts_num` LIKE '".$value."' ";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);
		$reason = $row['info'];
		$events = $row['events'];
		If ($row['srok'] !== '0000-00-00') {
			$srok = $row['srok'];
		} else {
			$srok = Null;
		}
		$ispolnitel = $row['ispolnitel'];
			
		
		// ВЫВОД на экран актуальной таблицы DELTA_SVERKA
		echo "<tr>
		<td span style=\"padding: 5px;\">".$k."</td>
		<td span style=\"padding: 5px;font-size: 14px;\"><a href='sverka_edit.php?bts_num=".$value."'><b>".$value."</b></a></td>
		<td span style=\"padding: 5px;text-align:left;\">".$emkost2[$value]."</td>
		<td span style=\"padding: 5px;text-align:left;\">".$reason."</td>
		<td span style=\"padding: 5px;text-align:left;\">".$events."</td>
		<td span style=\"padding: 5px;\">".$srok."</td>
		<td span style=\"padding: 5px;\">".$ispolnitel."</td></tr>";
		
		
		//Запись в таблицу Delta полученного результата сверки
	//1. Проверка на наличие этой БС в таблице DELTA_SVERKA (Если такая БС есть - то она не вноситься)
		$sql_search = "SELECT `bts_num` FROM `delta_sverka` WHERE `bts_num` like '".$value."' ";
		$result = mysqli_query($conn,$sql_search);
		if (mysqli_num_rows($result) > 0) {
			//Если такая БС уже есть в таблице DELTA_SVERKA, то ее не вносим и пропускаем этот шаг цикла
			continue; 
		} else { 
			//Если такой БС нет в таблице Delta, то ее вносим в таблицу DELTA_SVERKA
			$sql = "INSERT INTO `delta_sverka` (`bts_num`,`adress`) VALUES ('".$value."','".$emkost2[$value]."')";
			$result = mysqli_query($conn,$sql);
		}
	}
}
echo "</table>";


echo "</div>";
echo "</div>";


} 


?>