<?php ///////////////RENT таблица истории ///////////////////////////

include_once('../config.php');
include_once('../functions.php');
include_once('./core/function.php');
session_start();

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
} else {
$user_id = 0;
}

If ($_SESSION['rights'] == 'w') {
	$rights = 'Редактор';
} else {
	$rights = 'Чтение';
}


// входные параметры
$id = $_GET['id']; //Id объекта (в соответсвующей таблице Договоров

$objects = array (
	'rent' => 'договор'
   ,'number' => 'номер объекта'
   ,'dogovor_number' => 'номер договора'
);   
//Мы имеем массив objects только для одного типа объекта [БС ИЛИ репитер ИЛИ запись бюджета]
//Переписываем массив $objects в новый массив $fields и получаем массив ключей полей на английском 
//([budget,budget_addresses][bts,sectors,rrl,hardware],[repeaters,repeater_sectors])
foreach ($objects as $key => $value) {
  $fields[] = '"'.$key.'"';
}
//Запрос на выборку данных из таблицы истории (history)
$sql = "SELECT ";
$sql.= " act_date";
$sql.= ",act_time";
$sql.= ",surname";
$sql.= ",name";
$sql.= ",middle_name";
//$sql.= ",action";
$sql.= ",rent.type as type"; // тип объекта
$sql.= ",rent.dogovor_number as dog_number"; // тип объекта
$sql.= ",rent.number as object_number"; //Номер объекта - БС, Репитер, ФТТХ,....
$sql.= ",changes"; //нарушена кодировка 
$sql.= ",table_name";
$sql.= " FROM history_rent"; 
$sql.= " LEFT JOIN users"; //связка с таблицей пользователей
$sql.= " ON history_rent.user_id=users.Id";
$sql.= " LEFT JOIN rent"; //связка с таблицей пользователей
$sql.= " ON history_rent.object_id=rent.Id";
$sql.= " WHERE table_name like 'rent' AND object_id=$id ORDER BY history_rent.Id DESC"; //склеивает строки в одну по символам ","
//где поле table_name  в составе массива ключей $fields (любое из значений) и поле object_id равно id объекта (БСб Репитер или запись бюджета)
//сортировка по убыванию записей в таблице истории, т.е. показывать сверху самые свежие записи

$query=mysql_query($sql) or die(mysql_error());
//$row = mysql_fetch_assoc($query);

//echo "<pre>";
//print_r($row);
//echo "</pre>";

If ($sql) {
?>	
	
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " /> -->
    <title>ИСТОРИЯ <?php echo $row['type']." ".$row['object_number']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>
	<style type="text/css">
		#history {
			
			border-radius: 10px;
			margin: 3px;
			padding: 3px;
		}
		
		
		
	</style>
	
</head>
<body>

    <!-- шапка header-->
	<div id="cap" class="container mt-1" >
		<div class="row align-self-center" >
			<div class="col-12" >
					<div  class="container" >	
						<div class="row align-items-center">
                            <div class="col-md-9">
                                <div class="row align-items-center ">
                                    <div class="col-md-3 arend">
                                        <a href="/rent/index.php?Id=<?php echo $id; ?>"><button type="button" class="btn btn-danger" >НАЗАД</button></a>
                                    </div>
                                    
                                </div>
                            </div>

						    <div class="col-md-3" >
                                <div class="row align-items-center">
                                    <!-- ФОРМА АВТОРИЗАЦИИ -->
                                    <?php
									session_start();
                                    // блок ввода авторизации
                                    //if ($user_id == 0) {
                                    //    include('/login_form.php');
                                    //    }
                                            if ($user_id > 0) {
                                                     echo  "
                                                            <div class=\"col-8\">
                                                                    <div class='col log_info'>
                                                                         ". $_SESSION['user_surname'] ." 
                                                                         ". $_SESSION['user_name']."
                                                                         ". $_SESSION['middle_name'] ." 
																		 [". $_SESSION['reg_user'] ."]
																		 [".$rights."]																		 
                                                                    </div>
                                                               <div class=\"w-100\"></div>
                                                                    <div class='col'>
                                                                          <a href='logout.php'><button >выйти</button></a>
																		  "."Online:" . GetUsersOnline()."
                                                                    </div>			
                                                            </div>
                                                            <div id='log_info'  class=\"col-2\">   
                                                                   <img src='../pics/users/".$_SESSION['user_login'].".jpg' >
                                                            </div>                                                         
                                 </div>";
                                                }
                                    ?>
                               </div>
						  </div>		<!-- КОНЕЦ ФОРМЫ АВТОРИЗАЦИИ -->

						</div>
					</div>
			</div>
		</div>
	</div>	 <!--шапка header-->
	
	
<?php	
	
echo "<div  class='container mt-2'>";
// вывод элементов интерфейса
echo "<div id='history'>";
echo "<table>";   // таблица истории
echo "<tr>";// шапка таблицы истории
echo "<th>дата</th>"; //act_date
echo "<th>время</th>"; //act_time
echo "<th>пользов.</th>"; //surname name middle_name
echo "<th>объект</th>"; //table_name
//echo "<th>тип объекта</th>"; //table_name
echo "<th>номер объекта</th>"; //table_name
echo "<th>договор №</th>"; //table_name
//echo "<th>действие</th>"; //action
echo "<th>изменения</th>";  //changes
echo "</tr>";

for ($i=0; $i<mysql_num_rows($query); $i++) { //вывод данных из таблицы history
  $row = mysql_fetch_array($query);
  echo "<tr>";
  echo "<td>".$row['act_date']."</td>"; // Дата изменения
  echo "<td>".$row['act_time']."</td>"; // Время изменения
  $user = $row['surname']." ".(!empty($row['name'])? substr($row['name'],0,1).'.' : '').(!empty($row['middle_name'])? substr($row['middle_name'],0,1).'.' : '');
  //Составление пользователя по шаблону "Фамилия И.О." если имя и отчество есть в базе
  echo "<td>$user</td>"; //вывод "Фамилия И.О."
  $object = $objects['rent']; //тип объекта (БС,Бюджет,Репитер)
  echo "<td>".$row['type']."</td>"; //Вывод объекта
  //echo "<td>$id</td>"; //Вывод объекта id
  echo "<td><b>".$row['object_number']."</b></td>"; //Вывод номера объекта
  //if ($row['action'] == 'insert') $action = "добавлена запись"; // перевод поля на русский
  //if ($row['action'] == 'update') $action = "изменена запись";// перевод поля на русский
  //if ($row['action'] == 'delete') $action = "удалена запись";  // перевод поля на русский
  echo "<td>".$row['dog_number']."</td>"; //Вывод действия над объектом
  //echo "<td>$action</td>"; //Вывод действия над объектом
  echo "<td>";
  $changes = explode(';',$row['changes']); //разбивает строку на подмассивы с помощью разделителя в данном случае ";" и записывает в массив $changes
  for ($j=0; $j<count($changes); $j++) {
	 echo $changes[$j]; //Вывод подмассива (одной записи) из массива изменений $changes, разделенные ";"
	     
    if ($j+1 < count($changes) ) echo"<br>"; //Переход на новую строку при выводе всего подмассива
  }
  echo "</td>";
  echo "</tr>";
}

echo "</table>"; //Окончание таблицы
echo "</div>";

} else {
	echo "Данных в истории изменений нет!!!";
}
echo "</div>";
?> 