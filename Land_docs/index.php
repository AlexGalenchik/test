<?php
include_once('/core/config.php');
include_once('/core/function.php');
include_once('../config.php');
session_start();

// текущая дата
$today = date("Y-m-d");
//Дата + 3 месяца
$today3 = date("Y-m-d",mktime(0, 0, 0, date("m")+3,   date("d"),   date("Y")));

// Права доступа к Базе
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

//Присвоение переменных Район, Область и Нас пункт, Тип аренды, Арендодатель, Арендатор
if (isset($_POST['bts'])) { //(Адаптировано под БД ЗЕМЛИ)
    $bts = $_POST['bts'];
    $_SESSION['bts'] = $bts;
} else {
    $bts = '';
}
// Выбор области для Админа и не админа
IF ($_SESSION['reg_user'] == 'Админ') {
	if (isset($_POST['oblast'])) { //(Адаптировано под БД ЗЕМЛИ)
		$_SESSION['oblast'] = $_POST['oblast'];
	} 
} else {
	if ($_SESSION['reg_user'] == 'ОАДО') {
		$_SESSION['oblast'] = 'Минская';
		//$_POST['oblast'] = 'Минская';
	} else {
		$_SESSION['oblast'] = $_SESSION['reg_user'];
		//$_POST['oblast'] = $_SESSION['reg_user'];
	}
}


if (isset($_POST['raion'])) { //(Адаптировано под БД ЗЕМЛИ)
    $raion = $_POST['raion'];
    $_SESSION['raion'] = $raion;
} else {
	$raion = '';
}

// выборка по городу (Адаптировано под БД ЗЕМЛИ)
if (isset($_POST['nas_punkt'])) {
    $nas_punkt = clean ($_POST['nas_punkt']);
    $_SESSION['nas_punkt'] = $nas_punkt;
} else {
    $city = "";
}

// Тип аренды (Пользование и и аренда)
if (isset($_POST['type_pravo'])) { //(Адаптировано под БД ЗЕМЛИ)
    $type_pravo = $_POST['type_pravo'];
    $_SESSION['type_pravo'] = $type_pravo;
} else {
    $type_pravo = '';
}

if (isset($_POST['kadastroviy_number'])) { //(Адаптировано под БД ЗЕМЛИ)
    $kadastroviy_number = clean ($_POST['kadastroviy_number']);
    $_SESSION['kadastroviy_number'] = $kadastroviy_number;

} else {
    $kadastroviy_number = '';
}

// выборка по инвентарному номеру кап. троения (Адаптировано под БД ЗЕМЛИ)
if (isset($_POST['inventarniy_building'])) {
    $inventarniy = clean ($_POST['inventarniy_building']);
    $_SESSION['inventarniy_building'] = $inventarniy;
} else {
    $inventarniy = "";
}

// даты договоров
if (isset($_POST['dogovor_start_1'])) {    //(Адаптировано под БД ЗЕМЛИ)
    $dogovor_start_1 = $_POST['dogovor_start_1'];
    $_SESSION['dogovor_start_1'] = $dogovor_start_1;
} else {
    $dogovor_start_1 = '';
}

if (isset($_POST['dogovor_start_2'])) {    //(Адаптировано под БД ЗЕМЛИ)
    $dogovor_start_2 = $_POST['dogovor_start_2'];
    $_SESSION['dogovor_start_2'] = $dogovor_start_2;
} else {
    $dogovor_start_2 = '';
}

if (isset($_POST['dogovor_finish_1'])) {   //(Адаптировано под БД ЗЕМЛИ)
    $dogovor_finish_1 = $_POST['dogovor_finish_1'];
    $_SESSION['dogovor_finish_1'] = $dogovor_finish_1;
} else {
    $dogovor_finish_1 = '';
}
if (isset($_POST['dogovor_finish_2'])) {   //(Адаптировано под БД ЗЕМЛИ)
    $dogovor_finish_2 = $_POST['dogovor_finish_2'];
    $_SESSION['dogovor_finish_2'] = $dogovor_finish_2;
} else {
    $dogovor_finish_2 = '';
}

//валюта Договора
if (isset($_POST['type_currency'])) {   //(Адаптировано под БД ЗЕМЛИ)
    $type_currency = $_POST['type_currency'];
    $_SESSION['type_currency'] = $type_currency;
} else {
    $type_currency = '';
}

//  переменный поиска из адресной строки (Адаптировано под БД ЗЕМЛИ)
if (isset($_POST['adsearch'])) {
    $adsearch = clean ($_POST['adsearch']);
    $_SESSION['adsearch'] = $adsearch;
} else {
    $adsearch = "";
}


//  по новому Договору Аренды (Адаптировано под БД ЗЕМЛИ)
if (isset($_POST['dogovor_number'])) {
    $dogovor_number = clean ($_POST['dogovor_number']);
    $_SESSION['dogovor_number'] = $dogovor_number;
} else {
    $dogovor_number = "";
}

// дата Договора    (Адаптировано под БД ЗЕМЛИ)
if (!empty($_POST['dogovor_date'])) {
    $dogovor_date = $_POST['dogovor_date'];
    $_SESSION['dogovor_date'] = $dogovor_date;
} else {
    $dogovor_date = "";
}

// выборка по исполнителю  (Адаптировано под БД ЗЕМЛИ)
if (isset($_POST['ispolnitel'])) {
    $ispolnitel = ($_POST['ispolnitel']);
    $_SESSION['ispolnitel'] = $ispolnitel;
} else {
    $ispolnitel = "";
}

// выборка по исполнителю  (Адаптировано под БД ЗЕМЛИ)
if (isset($_POST['type_opori'])) {
    $type_opori = clean ($_POST['type_opori']);
    $_SESSION['type_opori'] = $type_opori;
} else {
    $type_opori = "";
}

//  по стоимости Договора     (Адаптировано под БД ЗЕМЛИ)
if (isset($_POST['summa_rent'])) {
    $summa_rent = ($_POST['summa_rent']);
    $_SESSION['summa_rent'] = $summa_rent;
} else {
    $summa_rent = "";
}

if (!empty($_POST['more_equal'])) {  //(Адаптировано под БД ЗЕМЛИ)
    $more_equal = $_POST['more_equal'];
    $_SESSION['more_equal'] = $more_equal;
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

$conn = connect(); // Подключение к БД

$data = []; // Исходный массив, в который будут вносится данные из запроса

//Выбор номера БС в зависимости от области		
$_SESSION['bts'] = $_POST['bts'];

function counter_string($conn){ //счётчик количества строк (записей/документов)
    	
    $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
    If (!empty($_SESSION['oblast'])) { //Фильтр по Области
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //Фильтр по Району
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //Фильтр по Нас пункту
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //Фильтр по номеру БС
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //Фильтр по номеру Договора аренды
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //Фильтр по дате договора аренды
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //Фильтр по типу вещного права
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //Фильтр по исполнителю
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //Фильтр по типу опоры
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //Фильтр по кадастровому номеру
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { //Фильтр по инвентарному номеру
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //Фильтр по дате начала действия Договора
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //Фильтр по дате окончания действия Договора
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //Фильтр по типу валюты
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //Фильтр по сумме Договора
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
        $sql .= " AND (raion LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR nas_punkt LIKE '%" . $_SESSION['adsearch'] . "%'
			OR bts LIKE '%" . $_SESSION['adsearch'] . "%'
			OR adress LIKE '%" . $_SESSION['adsearch'] . "%'
			OR type_opori LIKE '%" . $_SESSION['adsearch'] . "%'
			OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%'
			OR notes LIKE '%" . $_SESSION['adsearch'] . "%')";
    }
				
	$query =  mysqli_query($conn, $sql);
	
	$a = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row;
			
	}
	return count($a); //количество строк считает в массиве
	
}

//выбор данных из таблицы в виде массива
function select($conn){ //пагинация
    $offset = 0;
    if (isset($_GET['page']) AND trim($_GET['page']) !== '') {
        $offset = trim($_GET['page']);    }
		
	
		
	
    $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
	
	If (!empty($_SESSION['oblast'])) { //Фильтр по Области
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //Фильтр по Району
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //Фильтр по Нас пункту
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //Фильтр по номеру БС
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //Фильтр по номеру Договора аренды
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //Фильтр по дате договора аренды
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //Фильтр по типу вещного права
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //Фильтр по исполнителю
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //Фильтр по типу опоры
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //Фильтр по кадастровому номеру
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { //Фильтр по инвентарному номеру
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //Фильтр по дате начала действия Договора
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //Фильтр по дате окончания действия Договора
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //Фильтр по типу валюты
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //Фильтр по сумме Договора
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
        $sql .= " AND (raion LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR nas_punkt LIKE '%" . $_SESSION['adsearch'] . "%'
			OR bts LIKE '%" . $_SESSION['adsearch'] . "%'
			OR adress LIKE '%" . $_SESSION['adsearch'] . "%'
			OR type_opori LIKE '%" . $_SESSION['adsearch'] . "%'
			OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%'
			OR notes LIKE '%" . $_SESSION['adsearch'] . "%')";
    }
    
		 $sql .= " ORDER BY bts LIMIT 10 OFFSET " . $offset * 10;
		
	$query =  mysqli_query($conn, $sql);
	
	$a = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row;
			
	}
	return $a;
	
}

$data = select ($conn); //Присвоение данных выборки с помощью функции в массив DATA

function paginationCount($conn) //Счёт количества страниц с разбивкой по 10 строк
{
   
     $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
    If (!empty($_SESSION['oblast'])) { //Фильтр по Области
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //Фильтр по Району
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //Фильтр по Нас пункту
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //Фильтр по номеру БС
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //Фильтр по номеру Договора аренды
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //Фильтр по дате договора аренды
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //Фильтр по типу вещного права
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //Фильтр по исполнителю
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //Фильтр по типу опоры
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //Фильтр по кадастровому номеру
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { //Фильтр по инвентарному номеру
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //Фильтр по дате начала действия Договора
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //Фильтр по дате окончания действия Договора
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //Фильтр по типу валюты
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //Фильтр по сумме Договора
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
        $sql .= " AND (raion LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR nas_punkt LIKE '%" . $_SESSION['adsearch'] . "%'
			OR bts LIKE '%" . $_SESSION['adsearch'] . "%'
			OR adress LIKE '%" . $_SESSION['adsearch'] . "%'
			OR type_opori LIKE '%" . $_SESSION['adsearch'] . "%'
			OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%'
			OR notes LIKE '%" . $_SESSION['adsearch'] . "%')";
    }
    
    $result =  mysqli_query($conn, $sql);
    $result = mysqli_num_rows($result);
    $summarow = $result;  // число строк - записей в выборке
    return ceil($summarow / 10);
		
}

// Считаю количество страниц при 10 строк на страницу
$countPage = paginationCount($conn);

function data_no_pagination ($conn){ //счётчик количества строк (записей/документов)
    	
    $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
   If (!empty($_SESSION['oblast'])) { //Фильтр по Области
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //Фильтр по Району
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //Фильтр по Нас пункту
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //Фильтр по номеру БС
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //Фильтр по номеру Договора аренды
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //Фильтр по дате договора аренды
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //Фильтр по типу вещного права
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //Фильтр по исполнителю
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //Фильтр по типу опоры
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //Фильтр по кадастровому номеру
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { //Фильтр по инвентарному номеру
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //Фильтр по дате начала действия Договора
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //Фильтр по дате окончания действия Договора
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //Фильтр по типу валюты
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //Фильтр по сумме Договора
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
        $sql .= " AND (raion LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR nas_punkt LIKE '%" . $_SESSION['adsearch'] . "%'
			OR bts LIKE '%" . $_SESSION['adsearch'] . "%'
			OR adress LIKE '%" . $_SESSION['adsearch'] . "%'
			OR type_opori LIKE '%" . $_SESSION['adsearch'] . "%'
			OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%'
			OR notes LIKE '%" . $_SESSION['adsearch'] . "%')";
    }
				
	$query =  mysqli_query($conn, $sql);
	
	$a = [];
	// Заношу данные выгрузки из базы в массив DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row;
			
	}
	return $a; //количество строк считает в массиве
	
}

// Расчет количества типов Договоров в выборке
$summ_land = 0;
$summ_BYN = 0;
$summ_USD = 0;

$data_all = data_no_pagination ($conn);

For ($i = 0; $i < count($data_all); $i++) {
	If ($data_all[$i]['land_area'] !== NULL) {
		$summ_land += $data_all[$i]['land_area'];
	}
	If ($data_all[$i]['rent_BYN'] !== NULL) {
		$summ_BYN += $data_all[$i]['rent_BYN'];
	}
	If ($data_all[$i]['rent_USD'] !== NULL) {
		$summ_USD += $data_all[$i]['rent_USD'];
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--         <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>ДОКУМЕНТЫ на ЗЕМЛЮ</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href=" bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href=" ../rent/Style.css">
    <script defer src="../rent/script.js"></script>

</head>
<body>


<div id="cap" class="container mt-1" ><!-- шапка header-->
    <div class="row align-self-center" ><!-- row header-->
        <div class="col-12" > <!-- row col-12 -->
            <div  class="container" > <!-- 2 container -->
                <div class="row align-items-center"><!-- row 2 -->
                    <div class="col-md-3 push-9" >
						<div class="row align-items-center"><!-- row 3 -->
                            <!-- ФОРМА АВТОРИЗАЦИИ -->
                            <?php
                            // блок ввода авторизации
                            if ($user_id == 0) { //Форма для входа пользователя
                                include('login_form.php');
                            }
                            if ($user_id > 0) { //Форма вывода информации о пользователе
                                echo  "
                                       <div class=\"col-8\">
                                            <div class='col log_info'>
                                                 ". $_SESSION['user_surname'] ." 
                                                 ". $_SESSION['user_name']."
                                                 ". $_SESSION['middle_name']."
												 [". $_SESSION['reg_user']."]												 
												 [". $rights."]												 
                                            </div>
                                            <div class=\"w-100\"></div>
                                            <div class='col'>
                                                   <a href='logout.php'><button >Выйти</button></a>
												   "."Online:" . GetUsersOnline()."
                                             </div>			
                                       </div>
                                       <div id='log_info'  class=\"col-4\">   
                                             <img src='../pics/users/".$_SESSION['user_login'].".jpg' >
                                       </div>";
                            }
                            ?>
                        </div><!-- row 3 -->
                      
                    </div>


                    <div class="col-md-9 pull-3">
					<h4>БАЗА ДОКУМЕНТОВ НА ЗЕМЕЛЬНЫЕ УЧАСТКИ</h4>
<?php If ($user_id > 0) {  //Если залогинился - то все работает и показывает  ?>					
					
                        <div class="row align-items-center ">
							<div class="col-md-3 push-1">
                                <form action="index.php" method="post">
                                  <div class="pressMe" >
									<input type="submit" name="table_gen" type="button" class="btn btn-danger" value="ПОИСК" title="выгрузить по фильтрам">
									</div>
							</div>
							<div class="col-md-3" >
								<a href="loadExcel.php" target="_blank" title="Выгрузить в Excel"><button type="button" class="btn btn-danger" >Выгрузить в EXCEL</button></a>
							</div>
							<div class="col-md-2" >
								<?php If ($_SESSION['rights'] == 'w') { ?>
									<a href="new_bs.php" target="_blank"><button type="button" class="btn btn-danger" >NEW_NE</button></a>
								<?php } ?>
							</div>
							<div class="col-md-2" >
								<img  title="развернуть фильтры" id="buttonshow" src='../rent/images/icons8_100.png' >
								<a id="areset" href="reset.php" ><img  title="Сбросить фильтры" id="reset" src="/rent/images/reset_icon.svg"></a>
							</div>
							<div class="col-md-2" >
								<a href="../main.php" title="Выбор БД"><button type="button" class="btn btn-danger" >ВЫБОР БД</button></a>
							</div>
						    
						</div>
                    </div>
                </div>		
            </div> <!-- row 2 -->
        </div><!-- 2 container -->
    </div><!-- row col-12 -->
</div><!-- row header-->

<div id="addFilter"  class="container mt-2 pt-2 show_land" >
        <div class="row justify-content-end align-items-center" >
            <div class="col-8 order-last">
                <div class="row">
                    <div class="box1 col-md-6">
                        <label for="oblast">Область</label>
						<select  class="reg_oblast" name="oblast">
							<?php If ($_SESSION['reg_user'] == 'Админ') { 
								echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								echo "<option value=\"\"></option>";
								echo "<option value=\"Минская\">Минская</option>";
								echo "<option value=\"Брестская\">Брестская</option>";
								echo "<option value=\"Витебская\">Витебская</option>";
								echo "<option value=\"Гомельская\">Гомельская</option>";
								echo "<option value=\"Гродненская\">Гродненская</option>";
								echo "<option value=\"Могилевская\">Могилевская</option>";
							} else { 
								IF ($_SESSION['reg_user'] == 'ОАДО') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == 'Брестская') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == 'Витебская') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == 'Гомельская') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == 'Гродненская') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == 'Могилевская') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
							}
						?>		
						</select>
					</div>
					<div class="box1 col-md-6">
                    	<select  class="reg_bts" name="bts" >
							<option value=""></option>
                            <?php
							  //Выводим перечень всех БС в базе без повторов
							$sql = " SELECT DISTINCT `bts` FROM `land_docs_minsk` ";
							If (!empty($_SESSION['oblast'])) {
							$sql.= "WHERE `oblast` like '".$_SESSION['oblast']."' ";
							}
							$sql.=	" ORDER BY `bts` ";
                            $res = mysql_query($sql);
                            while($row = mysql_fetch_array($res)){
                                if (isset($row['bts']) ) {
                                    echo "<option value=".$row['bts'].">".$row['bts']."</option>";
									
                                }
                            }
                            ?>
						</select>
							<label for="bts">Номер NE</label>
					</div>
                     <div class="box1 col-md-6">
                        <select class="selectDistributs" name="raion"></select>
						<label for="raion">Район</label>
                    </div>
                    <div class="box1 col-md-6" >
                            <input  type="text" name="dogovor_number" value="<?= $_SESSION['dogovor_number']; ?>">
                            <label for="dogovor_number" >Номер ДА</label>
                    </div>
                    <div class="box1 col-md-6">
                        <input type="text" name="nas_punkt" value="<?= $_SESSION['nas_punkt']; ?>">
                        <label for="nas_punkt">Нас. Пункт</label>
                    </div>
                    <div class="box1 col-md-6">
                        <input  type="date" name="dogovor_date" value="<?=$_SESSION['dogovor_date']?>">
                        <label for="dogovor_date">Дата ДА</label>
                    </div>
                </div>
            </div>
			<div class="col-4 order-first">
                <div class="box1 col" >
                    <select  class="type_dogovor search_bs" name="type_pravo" >
						<option value="<?=$_SESSION['type_pravo']; ?>"><?=$_SESSION['type_pravo']; ?></option>
						<?php // ПЕРЕЧЕНЬ Типов Договоров
                         $res = mysql_query('SELECT DISTINCT `type_rent` FROM `land_docs_minsk` ORDER BY `type_rent`');
                        while($row2 = mysql_fetch_assoc($res)){
                            ?>
                            <option value="<?php echo $row2['type_rent']; ?>"><?php echo $row2['type_rent']; ?></option>
                        <?php } ?>

                    </select>
                    <label for="type_pravo">Вещное право</label>
                </div>
				<div class="box1 col" >
                    <input  type="text" name="kadastroviy_number" value="<?= $_SESSION['kadastroviy_number']; ?>">
                    <label for="kadastroviy_number" >Кадастровый № ЗУ </label>
                </div>
                <div class="box1 col" >
                    <input  type="text" name="inventarniy_building" value="<?= $_SESSION['inventarniy_building']; ?>">
                    <label for="inventarniy_building" >Инвентарный № КС </label>
                </div>
            </div>
			
			  <script defer>


                let arr = {
                    "Брестская" : ["",	"Барановичский" , "Березовский" , "Брестский" ,	"Ганцевичский" , "Дрогичинский" , "Жабинковский" , "Ивановский"
                        , "Ивацевичский", "Каменецкий" , "Кобринский" , "Лунинецкий" , "Ляховичский" , "Малоритский"
                        , "Пинский" , "Пружанский" ,	"Столинский" ]

                    ,"Витебская" :  ["", "Бешенковичский" ,	"Браславский" ,	"Верхнедвинский" , "Витебский" , "Глубокский" , "Городокский" ,	"Докшицкий" ,
                        "Дубровенский" , "Лепельский" ,	"Лиозненский" ,	"Миорский" , "Оршанский" , "Полоцкий" ,	"Поставский" , "Россонский" ,
                        "Сенненский" , "Толочинский" , "Ушачский" ,	"Чашникский" , "Шарковщинский" , "Шумилинский" ]

                    ,"Гомельская" : [ "", "Брагинский" , "Буда-Кошелевский" , "Ветковский" , "Гомельский" ,	"Добрушский" , "Ельский" , "Житковичский" ,
                        "Жлобинский" , "Калинковичский" , "Кормянский" , "Лельчицкий" ,	"Лоевский" , "Мозырский" ,	"Наровлянский" ,
                        "Октябрьский" ,	"Петриковский" , "Речицкий" , "Рогачевский" , "Светлогорский" ,	"Хойникский" , "Чечерский"]

                    ,"Гродненская" : [ "", "Берестовицкий" , "Волковысский" , "Вороновский" , "Гродненский" , "Дятловский" , "Зельвенский" , "Ивьевский" ,
                        "Кореличский" ,	"Лидский" ,	"Мостовский" ,	"Новогрудский" , "Островецкий" , "Ошмянский" , "Свислочский" ,	"Слонимский" ,
                        "Сморгонский" ,	"Щучинский"]

                    ,"Минская" : [ "", "Березинский" , "Борисовский" , "Вилейский" , "Воложинский" , "Дзержинский" , "Клецкий" , "Копыльский" ,	"Крупский" ,
                        "Логойский" , "Любанский" , "Минский" ,	"Молодечненский" , "Мядельский" , "Несвижский" , "Пуховичский" , "Слуцкий" ,
                        "Смолевичский" , "Солигорский" , "Стародорожский" ,	"Столбцовский" , "Узденский" , "Червенский" ]

                    ,"Могилевская" : [ "", "Белыничский" , "Бобруйский" , "Быховский" , "Глусский" , "Горецкий" , "Дрибинский" , "Кировский" , "Климовичский" ,
                        "Кличевский" , "Костюковичский" , "Краснопольский" , "Кричевский" , "Круглянский" , "Могилевский" , "Мстиславский" ,
                        "Осиповичский" , "Славгородский" , "Хотимский" , "Чаусский" , "Чериковский" ,"Шкловский" ]
                };

                // создаем селект для выбора районов
                var x = document.querySelector('.selectDistributs');
                console.log(x);
                x.setAttribute("id", "mySelect");
                x.setAttribute("name", "raion");
                // distr.appendChild(x);
                // создание   option
                let z = document.createElement("option");
                console.log(z);
                z.setAttribute("value", "");
                let t = document.createTextNode("<?=$_SESSION['raion']; ?>");
                z.appendChild(t);
                document.getElementById("mySelect").appendChild(z);
				console.log(document.getElementById("mySelect").appendChild(z));

                // функция onchange  срабатывает по изменению областей
                document.querySelector('.reg_oblast').onchange = function () {
                    // выбираем область в переменную selectRegion
                    let option = document.querySelectorAll('.reg_oblast option');
                    console.log(option);
                    for (let i = 0; i < option.length; i++) {
                        if (option[i].selected) {
                            var selectRegion = option[i].value;
                            console.log(selectRegion);
                        }
                    }

                    function myFunction() {
                        // выбираем районны
                        for(key in arr) {
                            if (selectRegion == key) {
                                let opt = document.querySelectorAll("#mySelect option");
                                for (let i = 0; i < opt.length; i++) {
                                    opt[i].remove();
                                }

                                for (let i = 0; i < arr[key].length; i++) {
                                    z = document.createElement("option");
                                    z.setAttribute("value", arr[key][i]);
                                    t = document.createTextNode(arr[key][i]);
                                    z.appendChild(t);
                                    document.getElementById("mySelect").appendChild(z);
                                }
                            }
                        }

                    }

                    myFunction();
                }

            </script>
			
        </div>
        <hr>
        <div class="row justify-content-start">

            <div class="col-2">
                <div class="datebox">
                    <p>Даты начала ДА</p>
                    <div class="box2" >
                        <input  type="date" name="dogovor_start_1" value="<?=$_SESSION['dogovor_start_1']?>" >
                        <label for="dogovor_start_1">С:&nbsp;</label>
                    </div>
                    <div class="box2" >
                        <input  type="date" name="dogovor_start_2" value="<?=$_SESSION['dogovor_start_2']?>" >
                        <label for="dogovor_start_2" >По:&nbsp;</label>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="datebox">
                    <p>Даты окончания ДА</p>
                    <div class="box2  " >
                        <input  type="date" name="dogovor_finish_1" value="<?=$_SESSION['dogovor_finish_1']?>" >
                         <label for="dogovor_finish_1">С:&nbsp;</label>
                    </div>
                    <div class="box2 " >
                        <input  type="date" name="dogovor_finish_2" value="<?=$_SESSION['dogovor_finish_2']?>" >
                        <label for="dogovor_finish_2" >По:&nbsp;</label>
                    </div>
                </div>
            </div>
            <div class="col-4">
                    <div class="datebox">
						<div class="box1 col">
                            <input id = "keyword" type="text" name="adsearch" title="поиск по полям одновременно (номер БС, адрес, тип опоры, исполнитель, примечания)" value="<?=$_SESSION['adsearch'];?>">
                            <label for="adsearch">Ключевое слово</label>
                        </div> 

                        <div class="box ">
                            <select  class="box" name="ispolnitel" >
								<option value="<?=$_SESSION['ispolnitel']; ?>"><?=$_SESSION['ispolnitel']; ?></option>
							<?php // ПЕРЕЧЕНЬ Исполнителей
								$res = mysql_query('SELECT DISTINCT `ispolnitel` FROM `land_docs_minsk` ORDER BY `ispolnitel`');
								while($row2 = mysql_fetch_assoc($res)){
                            ?>
								<option value="<?php echo $row2['ispolnitel']; ?>"><?php echo $row2['ispolnitel']; ?></option>
							<?php } ?>
							</select>
                            <label for="ispolnitel">Исполнитель</label>
                        </div>
						<div class="box ">
							<input class="box" type="text" name="type_opori" value="<?=$_SESSION['type_opori']; ?>">
                            <!-- <select  class="box" name="type_opori" >
								<option value="<?=$_SESSION['type_opori']; ?>"><?=$_SESSION['type_opori']; ?></option>
							<?php // ПЕРЕЧЕНЬ Исполнителей
								$res = mysql_query('SELECT DISTINCT `type_opori` FROM `land_docs_minsk` ORDER BY `type_opori`');
								while($row2 = mysql_fetch_assoc($res)){
                            ?>
								<option value="<?php echo $row2['type_opori']; ?>"><?php echo $row2['type_opori']; ?></option>
							<?php } ?>
							</select> -->
                            <label for="type_opori">Тип опоры</label>
                        </div>
                   </div>
            </div>

            <div class="col-4">
                <div class="datebox">
                    <div class="box">
                        <label for="type_currency">Тип валюты</label>
                        <select id="type_currency" name="type_currency">
                            <option value="<?=$_SESSION['type_currency']; ?>"><?=$_SESSION['type_currency']; ?></option>
                            <?php
                            if (isset($_SESSION['type_currency'])) {
                                echo "<option value=\"\"></option>";
                            }
                            ?>
                            <option value="BYN">BYN</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>
                    <div class="box1 col" >
                        <select class="more_equal" name="more_equal">
                            <option value="<?= $_SESSION['more_equal']; ?>"><?= $_SESSION['more_equal']; ?></option>
                            <option value=""></option>
							<option value="=">=</option>
                            <option value=">=">>=</option>
                            <option value="<="><=</option>
                        </select>
                        <input  class="more_equal"  type="number" name="summa_rent" value="<?= $_SESSION['summa_rent']; ?>">
                        <label for="summa_rent" >Сумма Договора</label>
                    </div>
                </div>
            </div>
        </div>

        </form>
    </div>
	
<?php

    //Вывод данных в таблицу если массив с данными DATA не пустой
     If (count($countPage)>=0) {
        echo "<div  class=\"container\" >"; // Шапка таблицы
        echo "<div class=\"row tablerow\">
   <table>
     <tr>
		<th class='bts_land'>PDF</th>	 
        <th class='bts_land'>Объект</th>
		<th class='bts_land'>Адрес</th>
		<th class='bts_land'>Тип<br/>опоры</th>
		<th class='bts_land'>Cвидет-во<br/>гос. рег. ЗУ</th>
		<th class='bts_land'>Кадастровый № ЗУ</th>
		<th class='bts_land'>Площадь ЗУ<br/>(Га)</th>
		<th class='bts_land'>Вещное<br/>право</th>
		<th class='bts_land'>Годовая<br/>АП</th>
		<th class='bts_land'>Инвентарный № КС</th>
		<th class='bts_land'>Свидетельство<br/>гос. рег. КС</th>
		<th class='bts_land'>Договор аренды</th>
		<th class='bts_land'>Срок действия<br/>ДА</th>
		<th class='bts_land'>Исполнитель</th>
	 </tr>"; 
		echo "<tr>";  //Вывод данных в таблицу
        for ($i=0; $i<count($data); $i++) {
        // проверка наличия номера NE
				$Id = $data[$i]['Id'];
                $bts = $data[$i]['bts'];
				$oblast = $data[$i]['oblast'];
				$raion = $data[$i]['raion'];
				$nas_punkt = $data[$i]['nas_punkt'];
				$adress = $data[$i]['adress'];      //New field
				$opora = $data[$i]['type_opori'];
				$svidetelstvo_land = $data[$i]['svidetelstvo_land'];
				$svidetelstvo_land_date = $data[$i]['svidetelstvo_land_date'];
				$svidetelstvo_land_date_new = date('d.m.Y',strtotime($data[$i]['svidetelstvo_land_date']));
				$kadastroviy_number = $data[$i]['kadastroviy_number']; 
				$land_area = $data[$i]['land_area'];
				$type_rent = $data[$i]['type_rent'];
				$rent_BYN = $data[$i]['rent_BYN'];
				$rent_USD = $data[$i]['rent_USD'];
				$inventarniy_building = $data[$i]['inventarniy_building'];
				$svidetelstvo_building = $data[$i]['svidetelstvo_building'];
				$svidetelstvo_building_date = $data[$i]['svidetelstvo_building_date'];
				$svidetelstvo_building_date_new = date('d.m.Y',strtotime($data[$i]['svidetelstvo_building_date']));
				$dogovor_number = $data[$i]['dogovor_number'];
				$dogovor_date = $data[$i]['dogovor_date'];
				$dogovor_date_new = date('d.m.Y',strtotime($data[$i]['dogovor_date']));
				$dogovor_start = $data[$i]['dogovor_start'];
				$dogovor_start_new = date('d.m.Y',strtotime($data[$i]['dogovor_start']));
				$dogovor_finish = $data[$i]['dogovor_finish'];
				$dogovor_finish_new = date('d.m.Y',strtotime($data[$i]['dogovor_finish']));
				//$resheniye_videlenie = $data[$i]['resheniye_videlenie'];  			//Поля стали не нужны
				//$resheniye_videlenie_date = $data[$i]['resheniye_videlenie_date'];	//Поля стали не нужны
				//$razreshenie_number = $data[$i]['razreshenie_number'];				//Поля стали не нужны
				//$razreshenie_number_date = $data[$i]['razreshenie_number_date'];		//Поля стали не нужны
				$notes = $data[$i]['notes'];
				$ispolnitel = $data[$i]['ispolnitel'];
				
				$type_link = "_ЗУ";
				
				$link = "scans_docs/".$oblast."/".$bts.$type_link.".pdf"; //Формирование пути к документу в папках
				
				If (file_exists($link) == TRUE) {
					echo "<td span style=\"padding: 5px;\"><b><a href='$link' target='_blank'><img src='../pics/info_picc.png' width='20px'></a></b></td>";
				} else {
					echo "<td span style=\"padding: 5px;\"></td>";
				}
				echo "<td><center><b><a href='dogovor.php?Id=$Id'>".$bts."</a></b></center></td>";
				echo "<td span style=\"padding: 5px;\">".$oblast." обл.,<br/> ".$raion." р-н,<br/> ".$nas_punkt;
				If (!empty($adress)) {
					echo ",<br/>".$adress."</td>";
				} else {
					echo "</td>";
				}
				echo "<td span style=\"padding: 5px;\">".$opora."</td>";
				echo "<td span style=\"padding: 5px;\"><b>".$svidetelstvo_land."</b>";
				If ($svidetelstvo_land_date !== NULL && $svidetelstvo_land_date !== '0000-00-00') {
					echo "<br/>".$svidetelstvo_land_date_new."</td>";
				} else {
					echo "</td>";
				}
				echo "<td span style=\"padding: 5px;\"><b>".$kadastroviy_number."</b></td>";
				echo "<td span style=\"padding: 5px;\">".$land_area."</td>";
				echo "<td span style=\"padding: 5px;\">".$type_rent." </td>";
				
				// Приведение к одной колонке по платежам по договору
				IF (!empty ($rent_BYN) && !empty ($rent_USD)) {
							$pay = $rent_BYN." BYN<br/>".$rent_USD." USD";
				} else {
						If (!empty ($rent_BYN)) {
							$pay = $rent_BYN." BYN";
						}
						If (!empty ($rent_USD)) {
							$pay = $rent_USD." USD";
						}
				}
				echo "<td span style=\"padding: 5px;\">".$pay."</td>";
				unset ($pay); // Обязательно надо очистить переменную, чтоб она не перешла на другую запись при выводе!!!
				echo "<td span style=\"padding: 5px;\"><b>".$inventarniy_building."</b></td>";
				echo "<td span style=\"padding: 5px;\"><b>".$svidetelstvo_building."</b>";
					IF ($svidetelstvo_building_date !== NULL && $svidetelstvo_building_date !== '0000-00-00') {
						echo "<br/>".$svidetelstvo_building_date_new."</td>";
					} else {
						echo "</td>";
					}
				echo "<td span style=\"padding: 5px;\"><b>".$dogovor_number."</b>";
					IF ($dogovor_date !== NULL && $dogovor_date !== '0000-00-00') {
						echo "<br/>".$dogovor_date_new."</td>";
					} else {
						echo "</td>";
					}
				echo "<td span style=\"padding: 5px;\">";
				    IF ($dogovor_start !== NULL && $dogovor_start !== '0000-00-00') {
						echo "c ".$dogovor_start_new;
					}
					IF ($dogovor_finish !== NULL && $dogovor_finish !== '0000-00-00') {
						IF ($dogovor_finish < $today) {
							echo "<br/>по <br/><span style=\"color:red;\">".$dogovor_finish."</td>";
						} else {
							IF ($dogovor_finish > $today AND $dogovor_finish < $today3) {
								echo "<br/>по <br/><span style=\"color:blue;\">".$dogovor_finish."</td>";
							} else {
								echo "<br/>по <br/>".$dogovor_finish."</td>";
							}
						}
					}
				echo "</td>";
				echo "<td span style=\"padding: 5px;font-size: 10px;\">".$ispolnitel."</td>";				
				//echo "<td span style=\"padding: 5px;\">".$resheniye_videlenie."<br/>от ".$resheniye_videlenie_date."</td>";
				//echo "<td span style=\"padding: 5px;\">".$razreshenie_number."<br/>от ".$razreshenie_number_date."</td>";
				//echo "<td span style=\"padding: 5px;\">".$notes."</td>";
				
			
			echo "</tr>";
        }
		
    } else {
        echo "<div  class=\"container mt-2\" >
		<h5><span style=\"color:red;\">Договоров не найдено</span></h5>
		</div>";
    }
    echo "</table>";
    echo "</div>";
    echo "</div>";
    ?>
    </div>
   
           
        </div>
    </div>
	
<div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-5 paginat">

                <?php
                // создаем массив в который заносим все существующий страницы
                $array = [];
                for ($i=0; $i < $countPage; $i++){
                    array_push($array, $i);
                }
                // тоже без удаления 1 и последнего элемента в массиве
                $new_first=reset($array); //Устанавливает номер страницы на первую (тоесть нолевую)
                $new_last = end($array); //Устанавливает страницу на последнюю (количество страниц -1)

                // первая и последняя стр массива
                //$firstElement = array_shift($array); // Извлекает первый элемент массива номеров страниц
                //$lastElement = array_pop($array); //Извлекает последний элемент массива номеров страниц

                // определяем текущую страницу
                if(isset($_GET['page'])){  //сли выбрана страница по номеру более 1ой, тогда присвоить этот номер переменной
                    $current = $_GET['page'];
                }
                else{
                    $current=$new_first; //Иначе присвоить номер первой страницы (ноль)
                }
				
				$_SESSION['page'] = $current; //Запись в сессию номера страницы, выбранной на главной, чтоб на нее вернуться из карточки
				
                // длинна массва
                //                echo count($array);
                $lang = count($array); //Длина массива = количество страниц
                // условия перелистывания
                $Previous = $current - 1;
                $Next=$current + 1;
                if($Previous<0){ $Previous=$current;   }
                if($Next>=$new_last){  $Next=$new_last;  }
                if($lang==0){  //Если страниц нет, тоесть ничего не найдено
                    $Next=$current;
                    $new_last=$current;
                }
                // вывод страниц +1
                $firstElement_d = 1+$new_first;
                $Previous_d = 1+$Previous;
                $current_d = 1+$current;
                $Next_d = 1+$Next;
                $lastElement_d = 1+$new_last;

                echo " <nav aria-label=\"...\">";
                echo "   <ul class=\"pagination\">";
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=$new_first\"><sup style=\"color: #0275d8;\">$firstElement_d</sup><img src=\"https://img.icons8.com/color/15/000000/double-left.png\"/></a></li>";
                if ($current_d != 1){ echo " <li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=$Previous\">Previous </a></li>";};
                echo " <li class=\"page-item active\">
                        <a class=\"page-link\" href=\"index.php?page=$current\">$current_d</a>
                        </li>";
                if($current_d != $new_last+1){
                echo " <li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=$Next\">Next </a></li>";};
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=$new_last\"><img src=\"https://img.icons8.com/color/15/000000/double-right.png\"/><sup style=\"color: #0275d8;\">$lastElement_d</sup></a></li>";
                echo "   </ul>";
                echo "</nav>";
				
				?>
            </div>
            <div class="col-5"><table>
                <tr style="color: #0275d8; font-size: 14px";><td>Найдено документов (строк)</td><td><b><?php $counter = counter_string ($conn); echo $counter; ?></b></td></tr>
				<tr style="color: #0275d8; font-size: 14px";><td>Cуммарная площадь (Га)</td><td><b><?php echo $summ_land; ?></b></td></tr>
				<tr style="color: #0275d8; font-size: 14px";><td>Итого сумма (BYN)</td><td><b><?php echo $summ_BYN; ?></b></td></tr>
				<tr style="color: #0275d8; font-size: 14px";><td>Итого сумма (USD)</td><td><b><?php echo $summ_USD; ?></b></td></tr>
				</table>
            </div>
        </div>
    </div>
<?php } ?>


</body>
</html>


