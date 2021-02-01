<?php

include_once('./core/config.php');
include_once('./core/function.php');
include_once('../config.php');
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

// обработка форм POST


//  echo $_POST['search_bs'];
//Присвоение переменных Район, Область и Нас пункт, Тип аренды, Арендодатель, Арендатор
if (isset($_POST['Region'])) {
    $reg = $_POST['Region'];
    $_SESSION['reg'] = $reg;
} else {
    $reg = '';
}


if (isset($_POST['Areas'])) {
    $area = $_POST['Areas'];
    $_SESSION['Areas'] = $area;
} else {
    $area = '';
}
if (isset($_POST['type_dogovor'])) {
    $type_dogovor = $_POST['type_dogovor'];
    $_SESSION['type_dogovor'] = $type_dogovor;
} else {
    $type_dogovor = '';
}
if (isset($_POST['dogovor_type'])) { //Добавлено поле фильтра по типу договора (аренда, услуга, коммунальные, субаренда...)
    $dogovor_type = $_POST['dogovor_type'];
    $_SESSION['dogovor_type'] = $dogovor_type;
} else {
    $dogovor_type = '';
}

if (isset($_POST['arendodatel'])) {
    $arendodatel = htmlspecialchars($_POST['arendodatel'], ENT_QUOTES, 'cp1251');
    $_SESSION['arendodatel'] = $arendodatel;

} else {
    $arendodatel = '';
}

if (isset($_POST['search_bs'])) {
    $number_bs = $_POST['search_bs'];
    $_SESSION['search_bs'] = $number_bs;
} else {
    $number_bs = '';
}
if (isset($_POST['type_bs'])) {
	$type_bs_selected = $_POST['type_bs'];  //////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////
	$_SESSION['type_bs'] = $type_bs_selected;///////////////////////////////////////////////////////////////////////////////////////////////////
}

//echo "Добавлен цвет даты окончания договора. Договор истек-красный; Договор истекает <3 мес.-синий; Договор истекает <7 мес.-зеленый; Более 7 мес.- черный"; 

// текущая дата
$today = date("Y-m-d");
//Дата + 3 месяца
$today3 = date("Y-m-d",mktime(0, 0, 0, date("m")+3,   date("d"),   date("Y")));
//Дата + 7 месяцев
$today7 = date("Y-m-d",mktime(0, 0, 0, date("m")+7,   date("d"),   date("Y")));


// даты договоров
if (isset($_POST['start_date_1'])) {
    $start_date_1 = $_POST['start_date_1'];
    $_SESSION['start_date_1'] = $start_date_1;
} else {
    $start_date_1 = '';
}

if (isset($_POST['start_date_2'])) {
    $start_date_2 = $_POST['start_date_2'];
    $_SESSION['start_date_2'] = $start_date_2;
} else {
    $start_date_2 = '';
}

if (isset($_POST['start_date_3'])) {
    $start_date_3 = $_POST['start_date_3'];
    $_SESSION['start_date_3'] = $start_date_3;
} else {
    $start_date_3 = '';
}
if (isset($_POST['start_date_4'])) {
    $start_date_4 = $_POST['start_date_4'];
    $_SESSION['start_date_4'] = $start_date_4;
} else {
    $start_date_4 = '';
}

// дата Договора
if (!empty($_POST['data_dog'])) {
    $data_dog = $_POST['data_dog'];
    $_SESSION['data_dog'] = $data_dog;
}

//валюта Договора
if (isset($_POST['type_currency'])) {
    $type_currency = $_POST['type_currency'];
    $_SESSION['type_currency'] = $type_currency;
} else {
    $type_currency = '';
}

//  переменный поиска из адресной строки
if (isset($_POST['adsearch'])) {
    $adsearch = htmlspecialchars($_POST['adsearch'], ENT_QUOTES, 'cp1251');
    $_SESSION['adsearch'] = $adsearch;
} else {
    $adsearch = "";
}


//  по новому Договору
if (isset($_POST['num_rent'])) {
    $num_rent = htmlspecialchars($_POST['num_rent'], ENT_QUOTES, 'cp1251');
    $_SESSION['num_rent'] = $num_rent;
} else {
    $num_rent = "";
}

// выборка по городу
if (isset($_POST['city'])) {
    $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'cp1251');
    $_SESSION['city'] = $city;
} else {
    $city = "";
}

// выборка по исполнителю
if (isset($_POST['woker'])) {
    $woker = htmlspecialchars($_POST['woker'], ENT_QUOTES, 'cp1251');
    $_SESSION['woker'] = $woker;
} else {
    $woker = "";
}

// выборка по подразделению
if (isset($_POST['division'])) {
    $division = htmlspecialchars($_POST['division'], ENT_QUOTES, 'cp1251');
    $_SESSION['division'] = $division;
} else {
    $division = "";
}

//  по стоимости Договора
if (isset($_POST['summa_rent'])) {
    $summa_rent = htmlspecialchars($_POST['summa_rent'], ENT_QUOTES, 'cp1251');
    $_SESSION['summa_rent'] = $summa_rent;
} else {
    $summa_rent = "";
}

if (!empty($_POST['more_equal'])) {
    $more_equal = $_POST['more_equal'];
    $_SESSION['more_equal'] = $more_equal;
}


$conn = connect();

//выбор данных из таблицы в виде массива
function select($conn){ //пагинация
    $offset = 0;
    if (isset($_GET['page']) AND trim($_GET['page']) != '') {
        $offset = trim($_GET['page']);    }

    // получение данных из БД
    If ($_SESSION['reg_user'] == 'Админ') { //Если зашел Администратор, то он должен видеть все области
        $sql = "SELECT * FROM  rent WHERE Id is not NULL";

        If (!empty($_SESSION['reg'])) { //Фильтр по Области - если администратор выбрал одну из областей
            $sql .= " AND region like '" . $_SESSION['reg'] . "' ";
        }
		If (!empty($_SESSION['division'])) { //Фильтр по подразделению
			$sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
		}

    } else {
        $sql = "SELECT * FROM  rent WHERE division like '" . $_SESSION['reg_user'] . "'"; //Если это не администратор, то он видит всегда свою область ответственности
    }
	
    If (!empty($_SESSION['Areas'])) { //Фильтр по району
        $sql .= " AND area like '" . $_SESSION['Areas'] . "' ";
    }
    If (!empty($_SESSION['type_dogovor'])) { //Фильтр по типу Аренды
        $sql .= " AND type_arenda like '" . $_SESSION['type_dogovor'] . "' ";
    }
	If (!empty($_SESSION['dogovor_type'])) { //Фильтр по типу Договора
        $sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
    }
    If (!empty($_SESSION['arendodatel'])) { // Фильтр по арендодателю
        $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
    }
    If (!empty($_SESSION['search_bs'])) { //Фильтр по номеру БС
        $sql .= " AND number like '" . $_SESSION['search_bs'] . "' ";
    }
    If (!empty($_SESSION['type_bs'])) { //Фильтр по типу площадки ///////////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql .= " AND type IN (";
			for($i=0; $i < count($_SESSION['type_bs']); $i++) {
				If ($i>0) {
        $sql .= ",'" .$_SESSION['type_bs'][$i]."'" ;
				}
				else {
		$sql .= "'" .$_SESSION['type_bs'][$i]."'" ;			
				}
		}
		$sql .= ") ";
		
    } //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    If (!empty($_SESSION['type_currency'])) { //Фильтр по типу площадки
        $sql .= " AND type_currency like '" . $_SESSION['type_currency'] . "' ";
    }

    If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2'])) { //Фильтр по дате начала действия Договора
        $sql .= " AND start_date_dogovor BETWEEN '" . $_SESSION['start_date_1'] . "' AND '" . $_SESSION['start_date_2'] . "' ";
    }

    If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4'])) { //Фильтр по дате окончания действия Договора
        $sql .= " AND finish_date_dogovor BETWEEN '" . $_SESSION['start_date_3'] . "' AND '" . $_SESSION['start_date_4'] . "' ";
    }

    If (!empty($_SESSION['num_rent'])) { //Фильтр по номеру Договора
        $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
    }

    If (!empty($_SESSION['summa_rent'])) { //Фильтр по сумме Договора
        $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
    }

    ///// город и исполнитель
    If (!empty($_SESSION['city'])) { //Фильтр по номеру Договора
        $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
    }
    If (!empty($_SESSION['woker'])) { //Фильтр по номеру Договора
        $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
    }
	If (!empty($_SESSION['data_dog'])) { //Фильтр дата Договора
        $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
    }

    If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
        $sql .= " AND (region LIKE '%" . $_SESSION['adsearch'] . "%' 
			OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' 
             )";
    }
	
// var_dump($sql);

    $sql .= " ORDER BY finish_date_dogovor LIMIT 10 OFFSET " . $offset * 10;
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
}

$data = select($conn);


//выбор данных для расчета валюты
function selectCurrency($conn)
{
    // получение данных из БД
    If ($_SESSION['reg_user'] == 'Админ') { //Если зашел Администратор, то он должен видеть все области
        $sql = "SELECT * FROM  rent WHERE Id is not NULL";
        If (!empty($_SESSION['reg'])) { //Фильтр по Области - если администратор выбрал одну из областей
            $sql .= " AND region like '" . $_SESSION['reg'] . "' ";
        }
		If (!empty($_SESSION['division'])) { //Фильтр по подразделению
			$sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
		}
    } else {
        $sql = "SELECT * FROM  rent WHERE division like '" . $_SESSION['reg_user'] . "'"; //Если это не администратор, то он видит всегда свою область
    }
    If (!empty($_SESSION['Areas'])) { //Фильтр по району
        $sql .= " AND area like '" . $_SESSION['Areas'] . "' ";
    }
    If (!empty($_SESSION['type_dogovor'])) { //Фильтр по типу Аренды
        $sql .= " AND type_arenda like '" . $_SESSION['type_dogovor'] . "' ";
    }
	If (!empty($_SESSION['dogovor_type'])) { //Фильтр по типу Договора
        $sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
    }
    If (!empty($_SESSION['arendodatel'])) { // Фильтр по арендодателю
        $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
    }
    If (!empty($_SESSION['search_bs'])) { //Фильтр по номеру БС
        $sql .= " AND number like '" . $_SESSION['search_bs'] . "' ";
    }
      If (!empty($_SESSION['type_bs'])) { //Фильтр по типу площадки ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql .= " AND type IN (";
			for($i=0; $i < count($_SESSION['type_bs']); $i++) {
				If ($i>0) {
        $sql .= ",'" .$_SESSION['type_bs'][$i]."'" ;
				}
				else {
		$sql .= "'" .$_SESSION['type_bs'][$i]."'" ;			
				}
		}
		$sql .= ") ";
		
    }     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    If (!empty($_SESSION['type_currency'])) { //Фильтр по типу площадки
        $sql .= " AND type_currency like '" . $_SESSION['type_currency'] . "' ";
    }
    If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2'])) { //Фильтр по дате начала действия Договора
        $sql .= " AND start_date_dogovor BETWEEN '" . $_SESSION['start_date_1'] . "' AND '" . $_SESSION['start_date_2'] . "' ";
    }
    If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4'])) { //Фильтр по дате окончания действия Договора
        $sql .= " AND finish_date_dogovor BETWEEN '" . $_SESSION['start_date_3'] . "' AND '" . $_SESSION['start_date_4'] . "' ";
    }

    If (!empty($_SESSION['num_rent'])) { //Фильтр по номеру Договора
        $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
    }

    If (!empty($_SESSION['summa_rent'])) { //Фильтр по сумме Договора
        $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
    }

    ///// город и исполнитель
    If (!empty($_SESSION['city'])) { //Фильтр по номеру Договора
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
    }
    If (!empty($_SESSION['woker'])) { //Фильтр по номеру Договора
        $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
    }
	If (!empty($_SESSION['data_dog'])) { //Фильтр дата Договора
        $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
    }

        If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
        $sql .= " AND (region LIKE '%" . $_SESSION['adsearch'] . "%' 
			OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' 
             )";
    }
	
	
    $result = mysqli_query($conn, $sql);
    $a = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $a[] = $row;
        }
    }
    return $a;
	
	
}



$dataCurrency = selectCurrency($conn);

// переменная считающая сумму валюты в запросе
$BAV = 0;
$BAV_NDS = 0;
$BV = 0;
$BV_NDS = 0;
$BYN = 0;
$BYN_NDS = 0;
$USD = 0;
$USD_NDS = 0;
$EUR = 0;
$EUR_NDS = 0;
$array_dogovor=[];
$numb_dogovorov = 0 ; // число договоров в выборке

//function clean($value = "") {
//    $value = trim($value);
//    $value = stripslashes($value);
//    $value = strip_tags($value);
//    $value = htmlspecialchars($value,ENT_QUOTES,'cp1251');
//    return $value;
//}

//var_dump($numb_dogovorov);
for ($i = 0; $i < count($dataCurrency); $i++) {

    $unic_dog_numb = clean($dataCurrency[$i]['arendodatel']) . clean($dataCurrency[$i]['dogovor_number']) . clean($dataCurrency[$i]['dogovor_date']);

//    var_dump($unic_dog_numb);
    if ( !in_array( $unic_dog_numb, $array_dogovor ) ) {
    array_push($array_dogovor, $unic_dog_numb);
    }
    if ($dataCurrency[$i]['type_currency'] == 'BYN') {
        $BYN += $dataCurrency[$i]['summa'];
        $BYN_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == 'БАВ') {
        $BAV += $dataCurrency[$i]['summa'];
        $BAV_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == 'БВ') {
        $BV += $dataCurrency[$i]['summa'];
        $BV_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == 'USD') {
        $USD += $dataCurrency[$i]['summa'];
        $USD_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == 'EUR') {
        $EUR += $dataCurrency[$i]['summa'];
        $EUR_NDS += $dataCurrency[$i]['nds2'];
    }
}

//echo "<pre>";
//var_dump($unic_dog_numb);
//echo "</pre>";

$BAV = number_format($BAV, 2, ',', ' ');
$BYN = number_format($BYN, 2, ',', ' ');
$EUR = number_format($EUR, 2, ',', ' ');
$USD = number_format($USD, 2, ',', ' ');
$BV = number_format($BV, 2, ',', ' ');
$BAV_NDS = number_format($BAV_NDS, 2, ',', ' ');
$BYN_NDS = number_format($BYN_NDS, 2, ',', ' ');
$EUR_NDS = number_format($EUR_NDS, 2, ',', ' ');
$USD_NDS = number_format($USD_NDS, 2, ',', ' ');
$BV_NDS = number_format($BV_NDS, 2, ',', ' ');


// переменная считающая кол-во строк в запросе
$summarow = 0;
function paginationCount($conn)
{
    global $summarow, $BAV, $BV, $BYN, $USD, $EUR;
    //$sql = "SELECT * FROM  rent WHERE Id IS NOT NULL";
    //If (!empty($_SESSION['reg'])) { //Фильтр по Области
    //    $sql .= " AND region like '" . $_SESSION['reg'] . "' ";
    //}
	If ($_SESSION['reg_user'] == 'Админ') { //Если зашел Администратор, то он должен видеть все области
        $sql = "SELECT * FROM  rent WHERE Id is not NULL";

        If (!empty($_SESSION['reg'])) { //Фильтр по Области - если администратор выбрал одну из областей
            $sql .= " AND region like '" . $_SESSION['reg'] . "' ";
        }
		If (!empty($_SESSION['division'])) { //Фильтр по подразделению
			$sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
		}

    } else {
        $sql = "SELECT * FROM  rent WHERE division like '" . $_SESSION['reg_user'] . "'"; //Если это не администратор, то он видит всегда свою область ответственности
    }
		
	
    If (!empty($_SESSION['Areas'])) { //Фильтр по району
        $sql .= " AND area like '" . $_SESSION['Areas'] . "' ";
    }
    If (!empty($_SESSION['type_dogovor'])) { //Фильтр по типу Аренды
        $sql .= " AND type_arenda like '" . $_SESSION['type_dogovor'] . "' ";
    }
	If (!empty($_SESSION['dogovor_type'])) { //Фильтр по типу Договора
        $sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
    }
    If (!empty($_SESSION['arendodatel'])) { // Фильтр по арендодателю
        $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
    }
    If (!empty($_SESSION['search_bs'])) { //Фильтр по номеру БС
        $sql .= " AND number like '" . $_SESSION['search_bs'] . "' ";
    }
     If (!empty($_SESSION['type_bs'])) { //Фильтр по типу площадки ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$sql .= " AND type IN (";
			for($i=0; $i < count($_SESSION['type_bs']); $i++) {
				If ($i>0) {
        $sql .= ",'" .$_SESSION['type_bs'][$i]."'" ;
				}
				else {
		$sql .= "'" .$_SESSION['type_bs'][$i]."'" ;			
				}
		}
		$sql .= ") ";
		
    } /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    If (!empty($_SESSION['type_currency'])) { //Фильтр по типу площадки
        $sql .= " AND type_currency like '" . $_SESSION['type_currency'] . "' ";
    }

    If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2'])) { //Фильтр по дате начала действия Договора
        $sql .= " AND start_date_dogovor BETWEEN '" . $_SESSION['start_date_1'] . "' AND '" . $_SESSION['start_date_2'] . "' ";
    }
    If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4'])) { //Фильтр по дате окончания действия Договора
        $sql .= " AND finish_date_dogovor BETWEEN '" . $_SESSION['start_date_3'] . "' AND '" . $_SESSION['start_date_4'] . "' ";
    }

    If (!empty($_SESSION['num_rent'])) { //Фильтр по номеру Договора
        $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
    }

    If (!empty($_SESSION['summa_rent'])) { //Фильтр по сумме Договора
        $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
    }

    ///// город и исполнитель
    If (!empty($_SESSION['city'])) { //Фильтр по номеру Договора
        $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
    }
    If (!empty($_SESSION['woker'])) { //Фильтр по номеру Договора
        $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
    }
	If (!empty($_SESSION['data_dog'])) { //Фильтр дата Договора
        $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
    }

        If (!empty($_SESSION['adsearch'])) { //Фильтр по ключевому слову
        $sql .= " AND (region LIKE '%" . $_SESSION['adsearch'] . "%' 
			OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' 
             )";
    }
    $result = mysqli_query($conn, $sql);
    $result = mysqli_num_rows($result);
    $summarow = $result;  // число строк - записей в выборке
    return ceil($result / 10);
}
$countPage = paginationCount($conn);

// Расчет количества типов Договоров в выборке
$types = []; //Массив для внесения всех типов из выбранной выборки
$z = 0; //Переменная считает кол-во Типов без названия

For ($i = 0; $i < count($dataCurrency); $i++) {
	If ($dataCurrency[$i]['type'] !== NULL) {
	$types[] = $dataCurrency[$i]['type'];
	} else {
		$z++;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<!--         <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>СПИСОК ДОГОВОРОВ</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>

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
                            if ($user_id == 0) {
                                include('/login_form.php');
                            }
                            if ($user_id > 0) {
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
					
					<h4>БАЗА ДОГОВОРОВ АРЕНДЫ</h4>
<?php If ($user_id > 0) {   //Если залогинился - то все работает и показывает  ?>						
                        <div class="row align-items-center ">
                            <div class="col-md-3 push-1">
						
                                <form action="geo_finder.php" method="post">
                                    <div class="pressMe">
									    <input type="submit" name="table_gen" type="button" class="btn btn-danger" value="ПОИСК">
                                    </div>
                            </div>

                            <div class="col-md-2">
                                <a href="loadExcel.php" target="_blank"><button type="button" class="btn btn-danger" >EXCEL</button></a>
                            </div>
                     <!--   <div class="col-md-2">
                                <a href="report.php" target="_blank"><button type="button" class="btn btn-danger" >ОТЧЕТЫ</button></a>
                            </div> -->
							<div class="col-md-2">
                                <a href="new_bs.php" target="_blank"><button type="button" class="btn btn-danger" >NEW_NE</button></a>
                            </div>
                            <div class="col-md-2">
<!--                                <a href="reset.php" ><button type="button" class="btn btn-danger" >СБРОСИТЬ ФИЛЬТРЫ</button></a>-->
                                <img  title="развернуть фильтры" id="buttonshow" src='./images/icons8_100.png' >
                                <a id="areset"   href="reset.php" > <img  title="сбросить фильтры" id="reset" src="./images/reset_icon.svg" > </a>
                            </div>
							<div class="col-md-2" >
								<a href="../main.php" title="Выбор БД"><button type="button" class="btn btn-danger" >ВЫБОР БД</button></a>
							</div>
						</div>
                    </div>
                </div>		<!-- КОНЕЦ ФОРМЫ АВТОРИЗАЦИИ -->
            </div> <!-- row 2 -->
        </div><!-- 2 container -->
    </div><!-- row col-12 -->
</div><!-- row header-->
</div>	 <!--шапка header-->


    <!-- Вставка формы для поиска по региону и району -->

    <div id="addFilter"  class="container mt-2 pt-2 show" >
        <div class="row justify-content-end align-items-center" >
            <div class="col-8 order-last">
                <div class="row">
                    <div class="box1 col-md-6">
                        <select  class="reg" name="Region" >
                            <option value="<?=$_SESSION['reg']; ?>"><?=$_SESSION['reg']; ?></option>
                            <?php
                            if (!empty($_SESSION['reg'])) {
                                echo "<option value=\"\"></option>";
                            }
                            ?>
                            <option value="Брестская">Брестская</option>
                            <option value="Витебская">Витебская</option>
                            <option value="Гомельская">Гомельская</option>
                            <option value="Гродненская">Гродненская</option>
                            <option value="Минская">Минская</option>
                            <option value="Могилевская">Могилевская</option>
                        </select>
                        <label for="Region">Область</label>
                    </div>
                    <div class="box1 col-md-6">
                        <div class="box1 col">
                            <input id = "keyword" type="text" title="Поиск по нескольким полям (Номер БС,Адрес,Тип аренды,Арендодатель,Арендатор,Исполнитель,Тип HW" value="<?=$_SESSION['adsearch'];?>" name="adsearch">
                            <label for="search_bs" style="font-weight:bold">Ключевое слово</label>
                        </div>
                    </div>

                    <div class="w-100"></div>
                    <div class="box1 col-md-6">
                        <select class="selectDistributs" ></select>
                        <label for="">Район</label>
                    </div>
                        <div class="box1 col-md-6" >
                            <input  type="text" name="num_rent" value="<?= $_SESSION['num_rent']; ?>">
                            <label for="num_rent" >Номер договора</label>
                        </div>
                    <div class="w-100"></div>
                    <div class="box1 col-md-6">
                        <input type="text" name="city" value="<?= $_SESSION['city']; ?>">
                        <label for="city">Город</label>
                    </div>
                    <div class="box1 col-md-6">
                        <input  type="date" name="data_dog" value="<?=$_SESSION['data_dog']?>">
                        <label for="data_dog">Дата договора</label>
                    </div>
                </div>
            </div>
            <div class="col-4 order-first">
                <div class="box1 col" >
                    <select  class="type_dog" name="type_dogovor">
					  <option value="<?=$_SESSION['type_dogovor']; ?>"><?=$_SESSION['type_dogovor']; ?></option>
                            <?php
                            if (!empty($_SESSION['type_dogovor'])) {
                                echo "<option value=\"\"></option>";
                            }
                            ?>
						<option value="МТС Арендует РПС">МТС Арендует РПС</option>
						 <option value="МТС Арендует Офисы и т.д.">МТС Арендует Офисы и т.д.</option>
                        <option value="МТС Сдает">МТС Сдает</option>
                       	<option value="Техническая поддержка">Техническая поддержка</option>
                    </select>
                    <label for="type_dogovor">Вид аренды</label>
                </div>
                <div class="w-100"></div>		

                <div class="box1 col" style="margin-right:5px;font-size:10px;">			
                    <select class="selectTypes" ></select>
                    <label for="" style="font-weight:bold;font-size:14px;">Тип объекта РПС</label>
                </div>
                <div class="w-100"></div>

                <div class="box1 col" >
                    <input  type="text" name="arendodatel" value="<?= $_SESSION['arendodatel']; ?>">
                    <label for="arendodatel"><?php If ($_SESSION['reg_user'] !== 'УРС') {echo 'Арендодатель';} else {echo 'Контрагент';} ?></label>
                </div>
                <div class="w-100"></div>

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
                x.setAttribute("name", "Areas");
                // distr.appendChild(x);
                // создание   option
                let z = document.createElement("option");
                // console.log(z);
                z.setAttribute("value", "");
                let t = document.createTextNode("<?=$_SESSION['Areas']; ?>");
                z.appendChild(t);
                document.getElementById("mySelect").appendChild(z);


                // функция onchange  срабатывает по изменению областей
                document.querySelector('.reg').onchange = function () {
                    // выбираем область в переменную selectRegion
                    let option = document.querySelectorAll('.reg option');
                    // console.log(option);
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
				
				let arrTypes = {
                    "МТС Арендует РПС" : ["БС" , "Репитер" , "FTTx" ,	"БС_FTTx" , "ВОЛС" , "ВОЛС в канализации" , "Wi-Fi", "коммутатор", "unit"]

                    ,"МТС Сдает" :  ["БС" ,	"ВОЛС" , "Канализация" , "Пом./строение" ]

					,"МТС Арендует Офисы и т.д." : ["Админ. пом." , "Салон связи" , "Технич. пом." , "Склад" ,	"Архив", "Админ.+Салон"]

                    ,"Техническая поддержка" : [ "" ]

                };

                 // создаем селект для выбора районов
                var y = document.querySelector('.selectTypes');
                console.log(y);
                y.setAttribute("id", "mySelectType");
				y.setAttribute("style", "height: 63px;");
                y.setAttribute("name", "type_bs[]");
				y.setAttribute("multiple", "multiple");
			
                // distr.appendChild(y);
                // создание   option
                let w = document.createElement("option");
                // console.log(w);
                //w.setAttribute("value", "");
                //let u = document.createTextNode("<?=$_SESSION['type_bs']; ?>");
                //w.appendChild(u);
                document.getElementById("mySelectType").appendChild(w);


                // функция onchange  срабатывает по изменению областей
                document.querySelector('.type_dog').onchange = function () {
                    // выбираем область в переменную selectRegion
                    let option = document.querySelectorAll('.type_dog option');
                    // console.log(option);
                    for (let k = 0; k < option.length; k++) {
                        if (option[k].selected) {
                            var selectTypes = option[k].value;
                            console.log(selectTypes);
                        }
                    }

                    function myFunctionTypes() {
                        // выбираем районны
                        for(keys in arrTypes) {
                            if (selectTypes == keys) {
                                let opts = document.querySelectorAll("#mySelectType option");
                                for (let m = 0; m < opts.length; m++) {
                                    opts[m].remove();
                                }

                                for (let i = 0; i < arrTypes[keys].length; i++) {
                                    w = document.createElement("option");
                                    w.setAttribute("value", arrTypes[keys][i]);
                                    u = document.createTextNode(arrTypes[keys][i]);
                                    w.appendChild(u);
                                    document.getElementById("mySelectType").appendChild(w);
                                }
                            }
                        }

                    }

                    myFunctionTypes();
                }

            </script>

        </div>
        <hr>
        <div class="row justify-content-start">

            <div class="col-2">
                <div class="datebox">
                    <p>Период начала</p>
                    <div class="box2" >
                        <input  type="date" name="start_date_1" value="<?=$_SESSION['start_date_1']?>" >
                        <label for="start_date_1">С: &nbsp;</label>
                    </div>
                    <div class="box2" >
                        <input  type="date" name="start_date_2" value="<?=$_SESSION['start_date_2']?>" >
                        <label for="start_date_2" >По: &nbsp;</label>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="datebox">
                    <p>Период окончания</p>
                    <div class="box2  " >
                        <input  type="date" name="start_date_3" value="<?=$_SESSION['start_date_3']?>" >
                         <label for="start_date_3">С: &nbsp;</label>
                    </div>
                    <div class="box2 " >
                        <input  type="date" name="start_date_4" value="<?=$_SESSION['start_date_4']?>" >
                        <label for="start_date_4" >По: &nbsp;</label>
                    </div>
                </div>
            </div>
            <div class="col-4">
                    <div class="datebox">
					 <?php If ($_SESSION['reg_user'] == 'Админ') { //Скрывает поле выбора региона подразделения для пользователей (не админов)?> 
                        <div class="box">
                            <label for="division">Подразделение</label>

                            <select   name="division" >
                                <option value="<?=$_SESSION['division']; ?>"><?=$_SESSION['division']; ?></option>
                                <?php
                                if (!empty($_SESSION['division'])) {
                                    echo "<option value=\"\"></option>";
                                }
                                ?>
                                <option value="ОАДО">ОАДО</option>
								<option value="УРС">УРС</option>
                                <option value="Брестская">Брестская</option>
                                <option value="Витебская">Витебская</option>
                                <option value="Гомельская">Гомельская</option>
                                <option value="Гродненская">Гродненская</option>
                                <option value="Могилевская">Могилевская</option>
                            </select>

                        </div>
					 <?php } // Конец скрытия ?> 

                        <div class="box">
                            <input  type="text" name="woker" value="<?= $_SESSION['woker']; ?>">
                            <label for="woker">Исполнитель </label>
                        </div>
						<div class="box" >
                            <select name="dogovor_type">
							    <option value="<?=$_SESSION['dogovor_type']; ?>"><?=$_SESSION['dogovor_type']; ?></option>
								<option value=""></option>
								<?php
								$res_types = mysql_query('SELECT DISTINCT `dogovor_type` FROM `rent` ORDER BY `dogovor_type`');
								while($row_types = mysql_fetch_assoc($res_types)){
									if (isset($row_types['dogovor_type'])) {
										echo "<option value='{$row_types['dogovor_type']}'>{$row_types['dogovor_type']}</option>";
									} 
										
									
								}
                            ?>
							</select>	
                            <label for="dogovor_type">Тип Договора</label>
                        </div>


                    </div>
            </div>

            <div class="col-4">
                <div class="datebox">
                    <div class="box" style="margin-right:5px">
                        <label for="type_currency">Тип валюты</label>
                        <select id="type_currency" name="type_currency">
                            <option value="<?=$_SESSION['type_currency']; ?>"><?=$_SESSION['type_currency']; ?></option>
                            <?php
                            if (isset($_SESSION['type_currency'])) {
                                echo "<option value=\"\"></option>";
                            }
                            ?>
                            <option value="BYN">BYN</option>
                            <option value="БАВ">БАВ</option>
                            <option value="БВ">БВ</option>
                            <option value="EUR">EUR</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>

                    <div class="box" >
                        <select  class="search_bs" name="search_bs" >
							<option value=''></option>
                            <?php
                            if(isset($_SESSION['search_bs'])) {
                                echo "<option value='{$_SESSION['search_bs']}'>{$_SESSION['search_bs']}</option>";
                            }
                            $res = mysql_query('SELECT DISTINCT `number` FROM `rent` ORDER BY `number`');
                            while($row9 = mysql_fetch_assoc($res)){
                                if (isset($row9['number']) ) {
                                    echo "<option value='{$row9['number']}'>{$row9['number']}</option>";
                                }
                            }
                            ?>


                        </select>
                        <label for="search_bs" style="font-weight:bold" title="NE - номер сетевого элемента (БС, FTTx, офис, ВОЛС)">Номер NE</label>
                    </div>

                    <div class="box1 col" >
                        <select class="more_equal" name="more_equal">
                            <option value="<?= $_SESSION['more_equal']; ?>"><?= $_SESSION['more_equal']; ?></option>
                            <option value="=">=</option>
                            <option value=">=">>=</option>
                            <option value="<="><=</option>
                        </select>
                        <input  class="more_equal"  type="text" name="summa_rent" value="<?= $_SESSION['summa_rent']; ?>">
                        <label for="summa_rent" >Сумма договора</label>
                    </div>
                </div>
            </div>
        </div>

        </form>
    </div>



    <?php


    If (count($countPage)>=0) {
        echo "<div  class=\"container\" >";
        echo "<div class=\"row tablerow\">
   <table>
     <tr>";
		echo "<th class='numberBS'>номер<br/> NE </th>";
		If ($_SESSION['reg_user'] !== 'УРС') {
       	echo "<th class='typePlace'>Тип объекта<br/>РПС</th>";
		}
		echo "<th class='adress'>адрес</th>";
		If ($_SESSION['reg_user'] !== 'УРС') {
			echo "<th class='arendodatel'>Арендодатель</th>";
			echo "<th class='arendodatel'>Арендатор</th>";
					
		} else {
			echo "<th class='arendodatel'>Котрагент</th>";
		}
		If ($_SESSION['reg_user'] !== 'УРС') {	
		echo "<th class='typeArendy'>Вид<br/>Аренды</th>";
		}
		If ($_SESSION['reg_user'] !== 'УРС') {
		 echo "<th class='typeDogovor'>Тип<br/>договора</th>";
		}
		
		echo 
        "<th class='numDogovor'>Номер<br/>договора</th>";
		echo 
		"<th class='dataDogovor'>Дата<br/>договора</th>
		<th class='dateStart'>Начало<br/>договора</th>
		<th  class='dateEnd'>Конец<br/>договора</th>";
		
		echo
		"<th class='summa'>Сумма</th>
		<th class='nds2'>НДС</th>";
		 If ($_SESSION['reg_user'] !== 'УРС') {
		echo "<th  class='kontragent'>Контрагент</th>";
		}
		If ($_SESSION['reg_user'] == 'УРС') {
		echo "<th  class='kontragent'>Примечания</th>";	
		}
 		echo "<th  class='worker'>Исполнитель</th>";
        echo"</tr>";
        for ($i=0; $i<count($data); $i++) {
        // проверка наличия номера NE
            if(!empty($data[$i]['number'])){
                $number_NE=$data[$i]['number'];
            }
            else {
                $number_NE="";
            }
			// Проверка наличия договора
			if(!empty($data[$i]['dogovor_number'])){
                $dog_Num=$data[$i]['dogovor_number'];
            }
            else {
                $dog_Num='нет данных';
            }
            // вывод адрреса - область, район если они естю
            if(!empty($data[$i]['region'])) {
                $regon_out = $data[$i]['region'] . " область, ";
            }
            else {
                $regon_out="";
            }
            if(!empty($data[$i]['area'])) {
                $area_out = $data[$i]['area'] . " район, ";
            }
            else {
                $area_out="";
            }


            $adress_dogovor = $regon_out." ".$area_out." ".$data[$i]['settlement']." ".$data[$i]['adress'];

				echo "<tr>";
				echo "<td><center><b><a href='index.php?Id={$data[$i]['Id']}'>{$number_NE}</a></b></center></td>";
			If ($_SESSION['reg_user'] !== 'УРС') {
            	echo "<td><center>".$data[$i]['type']."</center></td>";
			}
                echo "<td>".$adress_dogovor."</td>";
			If ($_SESSION['reg_user'] !== 'УРС') {
                echo "<td><center>".$data[$i]['arendodatel']."</center></td>
				<td><center>".$data[$i]['arendator']."</center></td>";
			} else {
				echo "<td><center>".$data[$i]['arendodatel']."</center></td>";  
			}
			If ($_SESSION['reg_user'] !== 'УРС') {
				If ($data[$i]['type_arenda'] == 'МТС Арендует РПС') {
				echo "<td style=\"background:BlanchedAlmond;\"><center>".$data[$i]['type_arenda']."</center></td>";
				}
				If ($data[$i]['type_arenda'] == 'МТС Арендует Офисы и т.д.') {
				echo "<td style=\"background:#F2F5A9;\"><center>".$data[$i]['type_arenda']."</center></td>";
				}
				If ($data[$i]['type_arenda'] == 'МТС Сдает') {
				echo "<td style=\"background:#CEF6CE;\"><center>".$data[$i]['type_arenda']."</center></td>";
				}
				If ($data[$i]['type_arenda'] == 'Техническая поддержка') {
				echo "<td style=\"background:#F8E0F7;\"><center>".$data[$i]['type_arenda']."</center></td>";
				}
					
			}
			If ($_SESSION['reg_user'] !== 'УРС') {
                echo "<td><center>".$data[$i]['dogovor_type']."</center></td>";
			}
			
                echo "<td><center><a href=\"agreement_list.php?dog=".$dog_Num."\">".$dog_Num."</a></center></td>";
				/////////////////////////////////Дата Договора///////////////////////////////////////////////////////////
				If ($data[$i]['dogovor_date'] !== NULL && $data[$i]['dogovor_date'] !== '0000-00-00') {
				$dog_date = getdate(strtotime($data[$i]['dogovor_date'])); //Функция формирует массив из всех составляющих времени (год, месяц, день, минуты, часы...)
				If ($dog_date[mday] < 10) {
					$day = '0'.$dog_date[mday];
				} else {
					$day = $dog_date[mday];
				}
				If ($dog_date[mon] < 10) {
					$month = '0'.$dog_date[mon];
				} else {
					$month = $dog_date[mon];
				}
					echo "<td><center>".$day.".".$month.".".$dog_date[year]."</center></td>";
				} else {
					echo "<td><center>Нет даты</center></td>";
				}
				
				//////////////////////////Дата начала Договора///////////////////////////////////////////////////////////
				If ($data[$i]['start_date_dogovor'] !== NULL && $data[$i]['start_date_dogovor'] !== '0000-00-00') {
				$start_dog = getdate(strtotime($data[$i]['start_date_dogovor'])); //Функция формирует массив из всех составляющих времени (год, месяц, день, минуты, часы...)
				
				If ($start_dog[mday] < 10) {
					$day_start = '0'.$start_dog[mday];
				} else {
					$day_start = $start_dog[mday];
				}
				If ($start_dog[mon] < 10) {
					$month_start = '0'.$start_dog[mon];
				} else {
					$month_start = $start_dog[mon];
				}
					echo "<td><center>".$day_start.".".$month_start.".".$start_dog[year]."</center></td>";
				} else {
					echo "<td><center>Нет даты</center></td>";	
				}
				
				/////////////////////////Дата окончания Договора////////////////////////////////////////////////////////
				If ($data[$i]['finish_date_dogovor'] !== NULL && $data[$i]['finish_date_dogovor'] !== '0000-00-00') {
				$finish_dog = getdate(strtotime($data[$i]['finish_date_dogovor'])); //Функция формирует массив из всех составляющих времени (год, месяц, день, минуты, часы...)
				
				If ($finish_dog[mday] < 10) {
					$day_finish = '0'.$finish_dog[mday];
				} else {
					$day_finish = $finish_dog[mday];
				}
				If ($finish_dog[mon] < 10) {
					$month_finish = '0'.$finish_dog[mon];
				} else {
					$month_finish = $finish_dog[mon];
				}
				
					If ($data[$i]['finish_date_dogovor'] < $today) {  //Подкраска красным истекших договоров	  
						echo "<td style=\"color:red;\"><center>".$day_finish.".".$month_finish.".".$finish_dog[year]."</center></td>";
					} else {
						If ($data[$i]['finish_date_dogovor'] >= $today AND $data[$i]['finish_date_dogovor'] < $today3) {
							echo "<td style=\"color:blue;\"><center>".$day_finish.".".$month_finish.".".$finish_dog[year]."</center></td>";
						} else {
							If ($data[$i]['finish_date_dogovor'] >= $today3 AND $data[$i]['finish_date_dogovor'] < $today7) {
								echo "<td style=\"color:green;\"><center>".$day_finish.".".$month_finish.".".$finish_dog[year]."</center></td>";
							} else {
								echo "<td><center>".$day_finish.".".$month_finish.".".$finish_dog[year]."</center></td>";
							}				
						}
					}
				} else {
					echo "<td><center>Нет даты</center></td>";
				}
			
				echo "<td><center>".$data[$i]['summa']." <br> ".$data[$i]['type_currency']."</center></td>
                <td><center>".$data[$i]['nds2']." <br> ".$data[$i]['type_currency']."</center></td>";
			If ($_SESSION['reg_user'] !== 'УРС') {
                echo "<td>".$data[$i]['contragent_data']."</td>";
			}
			If ($_SESSION['reg_user'] == 'УРС') {
				echo "<td><center>".$data[$i]['notes']."</center></td>";
			}
                echo "<td><center>".$data[$i]['ispolnitel']."</center></td>";
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
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-3 paginat">

                <?php
                // создаем массив в который заносим все существующий страницы
                $array = [];
				
                for ($i=0; $i < $countPage; $i++){  ///Функция переписывает в массив array номера элементов в массиве COUNT_Page от нуля до конца массива
                    array_push($array, $i);
                }
								
                // тоже без удаления 1 и последнего элемента в массиве
                $new_first=reset($array); //Получаем первый элемент массива (обычно 0)
                $new_last = end($array);  //Получаем последний элемент - номер последней страницы (если счет от нуля)

                // первая и последняя стр массива
                //$firstElement = array_shift($array);  //Выбирает из массива array первый элемент (0) и урезает сам массив на один элемент
                //$lastElement = array_pop($array); //Выбирает из массива array последний элемент и урезает сам массив на один элемент

                // определяем текущую страницу
                if(isset($_GET['page'])){
                    $current = $_GET['page'];
                }
                else{
                    $current=$new_first; //ЕСЛИ GET нету, то переводим на первую страницу
                }
				
				$_SESSION['page'] = $current; //Запись текущей страницы в Сессию, чтоб сделать возврат с карточки
				
                // длинна массва
                // echo count($array);
                $lang = count($array);
                // условия перелистывания
                $Previous = $current - 1;
                $Next=$current + 1;
				
                if($Previous<0){
					$Previous=$current; //Если номер страницы <0 то присвоим страницу = 0 
					}
                if($Next>=$new_last){ //Если номер страницы > чем последний элемент массива номеров страниц - то присвоим страницу = последней 
					$Next=$new_last;  
					}
				
                if($lang==0){ //Если страниц не найдено. Массив страниц равен нулю по количеству
                    $Next=$current;
                    $new_last=$current;
                }
 
				
                // вывод страниц +1 (чтоб нормально по человечески отображать нумерацию на кнопках перелистывания (от 1 до N+1 страниц)
                $firstElement_d = 1+$new_first;
                $Previous_d = 1+$Previous;
                $current_d = 1+$current;
                $Next_d = 1+$Next;
                $lastElement_d = 1+$new_last;

                echo " <nav aria-label=\"...\">";
                echo "   <ul class=\"pagination\">";
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"geo_finder.php?page=$new_first\"><sup style=\"color: #0275d8;\">$firstElement_d</sup><img src=\"https://img.icons8.com/color/15/000000/double-left.png\"/></a></li>";
                if ($current_d != 1){ echo " <li class=\"page-item\"><a class=\"page-link\" href=\"geo_finder.php?page=$Previous\">Previous </a></li>";};
                echo " <li class=\"page-item active\">
                        <a class=\"page-link\" href=\"geo_finder.php?page=$current\">$current_d</a>
                        </li>";
                if($current_d != $new_last+1){
                echo " <li class=\"page-item\"><a class=\"page-link\" href=\"geo_finder.php?page=$Next\">Next</a></li>";};
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"geo_finder.php?page=$new_last\"><img src=\"https://img.icons8.com/color/15/000000/double-right.png\"/><sup style=\"color: #0275d8;\">$lastElement_d</sup></a></li>";
                echo "   </ul>";
                echo "</nav>";
                ?>
            </div>
            <div class="col-4">
                <p style="color: #0275d8; font-size: 14px";>Итого <?=count($array_dogovor);?> договоров. Всего строк <?php echo count($types) + $z;?>
                    <?php echo " на сумму :" . " <br>";
					echo "<table>";
					echo "<tr><th>Платежи</th><th>НДС</th></tr>";
                    if ($BYN>0){
                        echo "<tr><td><b>".$BYN."</b> BYN</td><td><b>".$BYN_NDS."</b> BYN</td></tr>";
						
                    }
                    if ($EUR>0){
                        echo "<tr><td><b>".$EUR."</b> EUR</td><td><b>".$EUR_NDS."</b> EUR</td></tr>";
                    }
                    if ($USD>0){
                        echo "<tr><td><b>".$USD."</b> USD</td><td><b>".$USD_NDS."</b> USD</td></tr>";
                    }
                    if ($BAV>0){
                        echo "<tr><td><b>".$BAV."</b> БАВ</td><td><b>".$BAV_NDS."</b> БАВ</td></tr>";
                    }
                    if ($BV>0){
                        echo "<tr><td><b>".$BV."</b> БВ</td><td><b>".$BV_NDS."</b> БВ</td></tr>";
                    }
					echo "</table>";
                    ?></p>
            </div>
			<div class="col-5">
					<p style="color: #0275d8; font-size: 14px";><u>Объектов c типами = <?php echo count($types); ?>;</u> <u>Объектов без типа = <?php echo $z; ?>;</u><br/> 
                    <?php 
						$types = array_count_values($types); //Функция вычисляет количество уникальных элементов массива Types
						
						echo "<div style=\"margin-right:7px;\"><table>";
						echo "<tr><th>Тип оборудования</th><th>Количество</th></tr>";
						foreach($types as $key => $value) {
							//Вывод количества уникальных значений элементов по типам
							echo "<tr>";
							echo "<td><b>".$key."</b></td><td><b>".$value."</b></td>"; 
							echo "</tr>";
						}
						echo "</table></div>";
					?>
				</p>
            </div>
        </div>
    </div>
	
	
	
<?php }

mysqli_close($conn);
?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script  src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>