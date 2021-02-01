<?php

include_once('../config.php');
include_once('../functions.php');
include_once('./core/config.php');
include_once('./core/function.php');
session_start();


if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 0;
}

If ($_SESSION['rights'] == 'w') {
	$rights = '��������';
} else {
	$rights = '������';
}

// ��������� ���� POST


//  echo $_POST['search_bs'];
//���������� ���������� �����, ������� � ��� �����, ��� ������, ������������, ���������
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
    $type_bs = $_POST['type_bs'];
    $_SESSION['type_bs'] = $type_bs;
} else {
    $type_bs = '';
}

// ������� ����
$today = date("Y-m-d");


// ���� ���������
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

// ���� ��������
if (!empty($_POST['data_dog'])) {
    $data_dog = $_POST['data_dog'];
    $_SESSION['data_dog'] = $data_dog;
}


//var_dump( $data_dog);
//var_dump( $_POST['data_dog']);
//var_dump( $_SESSION['data_dog']);

//������ ��������
if (isset($_POST['type_currency'])) {
    $type_currency = $_POST['type_currency'];
    $_SESSION['type_currency'] = $type_currency;
} else {
    $type_currency = '';
}

//  ���������� ������ �� �������� ������
if (isset($_POST['adsearch'])) {
    $adsearch = htmlspecialchars($_POST['adsearch'], ENT_QUOTES, 'cp1251');
    $_SESSION['adsearch'] = $adsearch;
} else {
    $adsearch = "";
}

//var_dump( $_SESSION['adsearch']);
//var_dump( $adsearch );

//  �� ������ ��������
if (isset($_POST['num_rent'])) {
    $num_rent = htmlspecialchars($_POST['num_rent'], ENT_QUOTES, 'cp1251');
    $_SESSION['num_rent'] = $num_rent;
} else {
    $num_rent = "";
}

// ������� �� ������
if (isset($_POST['city'])) {
    $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'cp1251');
    $_SESSION['city'] = $city;
} else {
    $city = "";
}

// ������� �� �����������
if (isset($_POST['woker'])) {
    $woker = htmlspecialchars($_POST['woker'], ENT_QUOTES, 'cp1251');
    $_SESSION['woker'] = $woker;
} else {
    $woker = "";
}

// ������� �� �������������
if (isset($_POST['division'])) {
    $division = htmlspecialchars($_POST['division'], ENT_QUOTES, 'cp1251');
    $_SESSION['division'] = $division;
} else {
    $division = "";
}

//  �� ��������� ��������
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


//var_dump($_SESSION['more_equal']);

// ���������� ���������� - ���� �����������
//    if (isset($_GET['sort'])) {$sort = ' ORDER BY '.$_GET['sort'];}


//  ����������� � �� - � ����� ���� ��� ���� ������� ����������� � ��
//function connect()
//{
//    $conn = mysqli_connect('127.0.0.1', 'root', '', 'mts_dbase');
//    // ���������
//    mysqli_set_charset($conn, "cp1251");
//    // Check connection
//    if (!$conn) {
//        die("Connection failed: " . mysqli_connect_error());
//    }
//    return $conn;
//}

$conn = connect();



//����� ������ �� ������� � ���� �������
function select($conn){ //���������
    $offset = 0;
    if (isset($_GET['page']) AND trim($_GET['page']) != '') {
        $offset = trim($_GET['page']);    }

		
	
		
    // ��������� ������ �� ��
    If ($_SESSION['reg_user'] == '�����') { //���� ����� �������������, �� �� ������ ������ ��� �������
        $sql = "SELECT * FROM  rent WHERE Id is not NULL";

        If (!empty($_SESSION['reg'])) { //������ �� ������� - ���� ������������� ������ ���� �� ��������
            $sql .= " AND region like '" . $_SESSION['reg'] . "' ";
        }

    } else {
        $sql = "SELECT * FROM  rent WHERE division like '" . $_SESSION['reg_user'] . "'"; //���� ��� �� �������������, �� �� ����� ������ ���� ������� ���������������
    }
    If (!empty($_SESSION['Areas'])) { //������ �� ������
        $sql .= " AND area like '" . $_SESSION['Areas'] . "' ";
    }
    If (!empty($_SESSION['type_dogovor'])) { //������ �� ���� ��������
        $sql .= " AND type_arenda like '" . $_SESSION['type_dogovor'] . "' ";
    }
    If (!empty($_SESSION['arendodatel'])) { // ������ �� ������������
        $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
    }
    If (!empty($_SESSION['search_bs'])) { //������ �� ������ ��
        $sql .= " AND number like '" . $_SESSION['search_bs'] . "' ";
    }
    If (!empty($_SESSION['type_bs'])) { //������ �� ���� ��������
        $sql .= " AND type like '" . $_SESSION['type_bs'] . "' ";
    }

    If (!empty($_SESSION['type_currency'])) { //������ �� ���� ��������
        $sql .= " AND type_currency like '" . $_SESSION['type_currency'] . "' ";
    }

    If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2'])) { //������ �� ���� ������ �������� ��������
        $sql .= " AND start_date_dogovor BETWEEN '" . $_SESSION['start_date_1'] . "' AND '" . $_SESSION['start_date_2'] . "' ";
    }

    If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4'])) { //������ �� ���� ��������� �������� ��������
        $sql .= " AND finish_date_dogovor BETWEEN '" . $_SESSION['start_date_3'] . "' AND '" . $_SESSION['start_date_4'] . "' "; 
    }
	/*
	//���� ��������� �������� ��������. �������� � ���������� ������ �� �����������
		$sql .= " AND end_dogovor is NULL "; //��������� �������� 22.09.2020
	*/

    If (!empty($_SESSION['num_rent'])) { //������ �� ������ ��������
        $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
    }

    If (!empty($_SESSION['summa_rent'])) { //������ �� ����� ��������
        $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
    }

    ///// ����� � �����������
    If (!empty($_SESSION['city'])) { //������ �� ������ ��������
        $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
    }
    If (!empty($_SESSION['woker'])) { //������ �� ������ ��������
        $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
    }
	If ($_SESSION['reg_user'] == '�����') {
		If (!empty($_SESSION['division'])) { //������ �� �������������
			$sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
		}
	}

    If (!empty($_SESSION['data_dog'])) { //������ ���� ��������
        $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
    }

    If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
        $sql .= " AND region like '%" . $_SESSION['adsearch'] . "%' 
			OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' 
             ";

    }

    $sql .= " ORDER BY Id LIMIT 10 OFFSET " . $offset * 10;
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

//����� ������ ��� ������� ������
function selectCurrency($conn)
{
    // ��������� ������ �� ��
    If ($_SESSION['reg_user'] == '�����') { //���� ����� �������������, �� �� ������ ������ ��� �������
        $sql = "SELECT * FROM  rent WHERE Id is not NULL";
        If (!empty($_SESSION['reg'])) { //������ �� ������� - ���� ������������� ������ ���� �� ��������
            $sql .= " AND region like '" . $_SESSION['reg'] . "' ";
        }
    } else {
        $sql = "SELECT * FROM  rent WHERE Id is not NULL AND division like '" . $_SESSION['reg_user'] . "'"; //���� ��� �� �������������, �� �� ����� ������ ���� �������
    }
    If (!empty($_SESSION['Areas'])) { //������ �� ������
        $sql .= " AND area like '" . $_SESSION['Areas'] . "' ";
    }
    If (!empty($_SESSION['type_dogovor'])) { //������ �� ���� ��������
        $sql .= " AND type_arenda like '" . $_SESSION['type_dogovor'] . "' ";
    }
    If (!empty($_SESSION['arendodatel'])) { // ������ �� ������������
        $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
    }
    If (!empty($_SESSION['search_bs'])) { //������ �� ������ ��
        $sql .= " AND number like '" . $_SESSION['search_bs'] . "' ";
    }
    If (!empty($_SESSION['type_bs'])) { //������ �� ���� ��������
        $sql .= " AND type like '" . $_SESSION['type_bs'] . "' ";
    }
    If (!empty($_SESSION['type_currency'])) { //������ �� ���� ��������
        $sql .= " AND type_currency like '" . $_SESSION['type_currency'] . "' ";
    }
    If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2'])) { //������ �� ���� ������ �������� ��������
        $sql .= " AND start_date_dogovor BETWEEN '" . $_SESSION['start_date_1'] . "' AND '" . $_SESSION['start_date_2'] . "' ";
    }
    If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4'])) { //������ �� ���� ��������� �������� ��������
        $sql .= " AND finish_date_dogovor BETWEEN '" . $_SESSION['start_date_3'] . "' AND '" . $_SESSION['start_date_4'] . "' ";
    }
	/*
	//���� ��������� �������� ��������. �������� � ���������� ������ �� �����������
		$sql .= " AND end_dogovor is NULL "; //��������� �������� 22.09.2020
	*/

    If (!empty($_SESSION['num_rent'])) { //������ �� ������ ��������
        $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
    }

    If (!empty($_SESSION['summa_rent'])) { //������ �� ����� ��������
        $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
    }

    ///// ����� � �����������
    If (!empty($_SESSION['city'])) { //������ �� ������ ��������
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
    }
    If (!empty($_SESSION['woker'])) { //������ �� ������ ��������
        $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
    }
	If ($_SESSION['reg_user'] == '�����') {
		If (!empty($_SESSION['division'])) { //������ �� �������������
			$sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
		}
	}
    If (!empty($_SESSION['data_dog'])) { //������ ���� ��������
        $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
    }

    If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
        $sql .= " AND region like '%" . $_SESSION['adsearch'] . "%' 
            OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
            OR type LIKE '%" . $_SESSION['adsearch'] . "%' ";

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

For($i=0;$i<count($dataCurrency);$i++) {
	$number_object = $dataCurrency[$i]['number'];
	$objects[] = $number_object;
}



// ���������� ��������� ����� ������ � �������
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
$numb_dogovorov = 0 ; // ����� ��������� � �������

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
    if ($dataCurrency[$i]['type_currency'] == '���') {
        $BAV += $dataCurrency[$i]['summa'];
        $BAV_NDS += $dataCurrency[$i]['nds2'];
    }
    if ($dataCurrency[$i]['type_currency'] == '��') {
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


// ���������� ��������� ���-�� ����� � �������
$summarow = 0;
function paginationCount($conn)
{
    global $summarow, $BAV, $BV, $BYN, $USD, $EUR;
    $sql = "SELECT * FROM  rent WHERE Id IS NOT NULL";
    If (!empty($_SESSION['reg'])) { //������ �� �������
        $sql .= " AND region like '" . $_SESSION['reg'] . "' ";
    }
    If (!empty($_SESSION['Areas'])) { //������ �� ������
        $sql .= " AND area like '" . $_SESSION['Areas'] . "' ";
    }
    If (!empty($_SESSION['type_dogovor'])) { //������ �� ���� ��������
        $sql .= " AND type_arenda like '" . $_SESSION['type_dogovor'] . "' ";
    }
    If (!empty($_SESSION['arendodatel'])) { // ������ �� ������������
        $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
    }
    If (!empty($_SESSION['search_bs'])) { //������ �� ������ ��
        $sql .= " AND number like '" . $_SESSION['search_bs'] . "' ";
    }
    If (!empty($_SESSION['type_bs'])) { //������ �� ���� ��������
        $sql .= " AND type like '" . $_SESSION['type_bs'] . "' ";
    }

    If (!empty($_SESSION['type_currency'])) { //������ �� ���� ��������
        $sql .= " AND type_currency like '" . $_SESSION['type_currency'] . "' ";
    }

    If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2'])) { //������ �� ���� ������ �������� ��������
        $sql .= " AND start_date_dogovor BETWEEN '" . $_SESSION['start_date_1'] . "' AND '" . $_SESSION['start_date_2'] . "' ";
    }
    If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4'])) { //������ �� ���� ��������� �������� ��������
        $sql .= " AND finish_date_dogovor BETWEEN '" . $_SESSION['start_date_3'] . "' AND '" . $_SESSION['start_date_4'] . "' "; 
    }
	/*
	//���� ��������� �������� ��������. �������� � ���������� ������ �� �����������
		$sql .= " AND end_dogovor is NULL "; //��������� �������� 22.09.2020
	*/

    If (!empty($_SESSION['num_rent'])) { //������ �� ������ ��������
        $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
    }

    If (!empty($_SESSION['summa_rent'])) { //������ �� ����� ��������
        $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
    }

    ///// ����� � �����������
    If (!empty($_SESSION['city'])) { //������ �� ������ ��������
        $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
    }
    If (!empty($_SESSION['woker'])) { //������ �� ������ ��������
        $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
    }
	If ($_SESSION['reg_user'] == '�����') {
		If (!empty($_SESSION['division'])) { //������ �� �������������
			$sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
		}
    }

    If (!empty($_SESSION['data_dog'])) { //������ ���� ��������
        $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
    }
	
	 If (!empty($_SESSION['reg_user']) AND $_SESSION['reg_user'] != '�����') { //������ ������������� ������ ��������� �������� 30.07.2020
        $sql .= " AND division LIKE '" . $_SESSION['reg_user'] . "'   ";
    }

    If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
        $sql .= " AND region like '%" . $_SESSION['adsearch'] . "%' 
        OR area LIKE '%" . $_SESSION['adsearch'] . "%' 
        OR settlement LIKE '%" . $_SESSION['adsearch'] . "%' 
        OR adress LIKE '%" . $_SESSION['adsearch'] . "%' 
        OR type_arenda LIKE '%" . $_SESSION['adsearch'] . "%' 
        OR arendodatel LIKE '%" . $_SESSION['adsearch'] . "%' 
        OR arendator LIKE '%" . $_SESSION['adsearch'] . "%' 
        OR number LIKE '%" . $_SESSION['adsearch'] . "%' 
        OR ispolnitel LIKE '%" . $_SESSION['adsearch'] . "%' 
        OR type LIKE '%" . $_SESSION['adsearch'] . "%' ";
		
    }
    $result = mysqli_query($conn, $sql);
    $result = mysqli_num_rows($result);
    $summarow = $result;  // ����� ����� - ������� � �������
    return ceil($result / 10);
}
$countPage = paginationCount($conn);

//var_dump($_SESSION['type_dogovor']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<!--         <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>������ ���������</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style.css">
    <script defer src="script.js"></script>

</head>
<body>


<div id="cap" class="container mt-1" ><!-- ����� header-->
    <div class="row align-self-center" ><!-- row header-->
        <div class="col-12" > <!-- row col-12 -->
            <div  class="container" > <!-- 2 container -->
                <div class="row align-items-center"><!-- row 2 -->
                    <div class="col-md-3 push-9" >
                        <div class="row align-items-center"><!-- row 3 -->
                            <!-- ����� ����������� -->
                            <?php
                            // ���� ����� �����������
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
                                                   <a href='logout.php'><button >�����</button></a>
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
                        <div class="row align-items-center ">
                            <div class="col-md-3 push-1">
                                <form action="geo_finder.php" method="post">
                                    <div class="pressMe">
                                        <input type="submit" name="table_gen" type="button" class="btn btn-danger" value="���������">
                                    </div>
                            </div>

                            <div class="col-md-3  arend">
                                <a href="loadExcel.php" target="_blank"><button type="button" class="btn btn-danger" >��������� � EXCEL</button></a>
                            </div>
                            <div class="col-md-3  arend">
<!--                                <button type="button" id="buttonshow" class="btn btn-danger">���������� �������</button>-->
                                <a href="report.php" target="_blank"><button type="button" class="btn btn-danger" >������</button></a>

                            </div>
                            <div class="col-md-3  arend">
<!--                                <a href="reset.php" ><button type="button" class="btn btn-danger" >�������� �������</button></a>-->
                                <img  title="���������� �������" id="buttonshow" src='./images/icons8_100.png' >
                                <a id="areset"   href="reset.php" > <img  title="�������� �������" id="reset" src="./images/reset_icon.svg" > </a>
                            </div>
                        </div>
                    </div>
                </div>		<!-- ����� ����� ����������� -->
            </div> <!-- row 2 -->
        </div><!-- 2 container -->
    </div><!-- row col-12 -->
</div><!-- row header-->
</div>	 <!--����� header-->

<?php If ($user_id > 0) {    ?>

    <!-- ������� ����� ��� ������ �� ������� � ������ -->



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
                            <option value="���������">���������</option>
                            <option value="���������">���������</option>
                            <option value="����������">����������</option>
                            <option value="�����������">�����������</option>
                            <option value="�������">�������</option>
                            <option value="�����������">�����������</option>
                        </select>
                        <label for="">�������</label>
                    </div>
                    <div class="box1 col-md-6">
                        <div class="box1 col">
                            <input id = "keyword" type="text" value="<?=$_SESSION['adsearch'];?>" name="adsearch">
                            <label for="search_bs" style="font-weight:bold">�������� �����</label>
                        </div>
                    </div>


                    <div class="w-100"></div>

                    <div class="box1 col-md-6">
                        <select class="selectDistributs"></select>
                        <label for="">�����</label>
                    </div>

                        <div class="box1 col-md-6" >
                            <input  type="text" name="num_rent" value="<?= $_SESSION['num_rent']; ?>">
                            <label for="num_rent" >����� ��������</label>
                        </div>

                    <div class="w-100"></div>

                    <div class="box1 col-md-6">
                        <input type="text" name="city" value="<?= $_SESSION['city']; ?>">
                        <label for="city">�����</label>
                    </div>

                    <div class="box1 col-md-6">
                        <input  type="date" name="data_dog" value="<?=$_SESSION['data_dog']?>">
                        <label for="data_dog">���� ��������</label>
                    </div>


                </div>
            </div>
            <div class="col-4 order-first">
                <div class="box1 col" >
                    <select  class="type_dogovor search_bs" name="type_dogovor" >
                        <option value="<?=$_SESSION['type_dogovor']; ?>"><?=$_SESSION['type_dogovor']; ?></option>
						<option value=""></option>
                        <?php // �������� ����� ���������
                        $res = mysql_query('SELECT DISTINCT `type_arenda` FROM `rent` ORDER BY `type_arenda`');
                        while($row2 = mysql_fetch_assoc($res)){
                            ?>					
                            <option value="<?php echo $row2['type_arenda']; ?>"><?php echo $row2['type_arenda']; ?></option>
			             <?php } ?>
						
                    </select>
                    <label for="type_dogovor">��� ��������</label>
                </div>
                <div class="w-100"></div>

                <div class="box1 col" >
                    <select  class="search_bs" name="type_bs" >
                        <option value="<?=$_SESSION['type_bs']; ?>"><?=$_SESSION['type_bs']; ?></option>
                       <?php
                        if (!empty($_SESSION['type_bs'])) {
                            echo "<option value=\"\"></option>";
                        }


                        ?>
                        <?php    // �������� ����� ���������
                        $res = mysql_query('SELECT DISTINCT `type` FROM `rent` ORDER BY `type`');
                        while($row2 = mysql_fetch_assoc($res)){
                        ?>
                        <option value="<?php echo $row2['type']; ?>"><?php echo $row2['type']; ?></option>
                        <?php } ?>
                    </select>
                    <label for="search_bs" style="font-weight:bold;">��� ��������</label>
                </div>
                <div class="w-100"></div>

                <div class="box1 col" >
                    <input  type="text" name="arendodatel" value="<?= $_SESSION['arendodatel']; ?>">
                    <label for="arendodatel" >������������</label>
                </div>



                <div class="w-100"></div>

            </div>

            <script defer>


                let arr = {
                    "���������" : ["",	"�������������" , "�����������" , "���������" ,	"������������" , "������������" , "������������" , "����������"
                        , "������������", "����������" , "����������" , "����������" , "�����������" , "�����������"
                        , "�������" , "����������" ,	"����������" ]

                    ,"���������" :  ["", "��������������" ,	"�����������" ,	"��������������" , "���������" , "����������" , "�����������" ,	"���������" ,
                        "������������" , "����������" ,	"�����������" ,	"��������" , "���������" , "��������" ,	"����������" , "����������" ,
                        "����������" , "�����������" , "��������" ,	"����������" , "�������������" , "�����������" ]

                    ,"����������" : [ "", "����������" , "����-�����������" , "����������" , "����������" ,	"����������" , "�������" , "������������" ,
                        "����������" , "��������������" , "����������" , "����������" ,	"��������" , "���������" ,	"������������" ,
                        "�����������" ,	"������������" , "��������" , "�����������" , "�������������" ,	"����������" , "���������"]

                    ,"�����������" : [ "", "�������������" , "������������" , "�����������" , "�����������" , "����������" , "�����������" , "���������" ,
                        "�����������" ,	"�������" ,	"����������" ,	"������������" , "�����������" , "���������" , "�����������" ,	"����������" ,
                        "�����������" ,	"���������"]

                    ,"�������" : [ "", "�����������" , "�����������" , "���������" , "�����������" , "�����������" , "�������" , "����������" ,	"��������" ,
                        "���������" , "���������" , "�������" ,	"��������������" , "����������" , "����������" , "�����������" , "�������" ,
                        "������������" , "�����������" , "��������������" ,	"������������" , "���������" , "����������" ]

                    ,"�����������" : [ "", "�����������" , "����������" , "���������" , "��������" , "��������" , "����������" , "���������" , "������������" ,
                        "����������" , "��������������" , "��������������" , "����������" , "�����������" , "�����������" , "������������" ,
                        "������������" , "�������������" , "���������" , "��������" , "�����������" ,"���������" ]
                };

                // ������� ������ ��� ������ �������
                var x = document.querySelector('.selectDistributs');
                console.log(x);
                x.setAttribute("id", "mySelect");
                x.setAttribute("name", "Areas");
                // distr.appendChild(x);
                // ��������   option
                let z = document.createElement("option");
                // console.log(z);
                z.setAttribute("value", "");
                let t = document.createTextNode("<?=$_SESSION['Areas']; ?>");
                z.appendChild(t);
                document.getElementById("mySelect").appendChild(z);


                // ������� onchange  ����������� �� ��������� ��������
                document.querySelector('.reg').onchange = function () {
                    // �������� ������� � ���������� selectRegion
                    let option = document.querySelectorAll('.reg option');
                    // console.log(option);
                    for (let i = 0; i < option.length; i++) {
                        if (option[i].selected) {
                            var selectRegion = option[i].value;
                            console.log(selectRegion);
                        }
                    }

                    function myFunction() {
                        // �������� �������
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
                    <p>������ ������</p>
                    <div class="box2" >
                        <input  type="date" name="start_date_1" value="<?=$_SESSION['start_date_1']?>" >
                        <label for="start_date_1">�: &nbsp;</label>
                    </div>
                    <div class="box2" >
                        <input  type="date" name="start_date_2" value="<?=$_SESSION['start_date_2']?>" >
                        <label for="start_date_2" >��: &nbsp;</label>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="datebox">
                    <p>������ ���������</p>
                    <div class="box2  " >
                        <input  type="date" name="start_date_3" value="<?=$_SESSION['start_date_3']?>" >
                         <label for="start_date_3">�: &nbsp;</label>
                    </div>
                    <div class="box2 " >
                        <input  type="date" name="start_date_4" value="<?=$_SESSION['start_date_4']?>" >
                        <label for="start_date_4" >��: &nbsp;</label>
                    </div>
                </div>
            </div>
			
            <div class="col-4">
                    <div class="datebox">
					<?php If ($_SESSION['reg_user'] == '�����') { ?> <!-- ���� ��� ������ ������� �������� ������ ������. � ��������� ��� ��� ����� �� �������� -->
                        <div class="box">
                            <label for="division">�������������</label>

                            <select   name="division" >
                                <option value="<?=$_SESSION['division']; ?>"><?=$_SESSION['division']; ?></option>
                                <?php
                                if (!empty($_SESSION['division'])) {
                                    echo "<option value=\"\"></option>";
                                }
                                ?>
                                <option value="����">����</option>
                                <option value="���������">���������</option>
                                <option value="���������">���������</option>
                                <option value="����������">����������</option>
                                <option value="�����������">�����������</option>
                                <option value="�����������">�����������</option>
                            </select>

                        </div>
					<?php } ?>	

                        <div class="box ">
                            <input  type="text" name="woker" value="<?= $_SESSION['woker']; ?>">
                            <label for="woker">�����������</label>
                        </div>


                    </div>
            </div>
			
            <div class="col-4">
                <div class="datebox">
                    <div class="box">
                        <label for="type_currency">��� ������</label>
                        <select id="type_currency" name="type_currency">
                            <option value="<?=$_SESSION['type_currency']; ?>"><?=$_SESSION['type_currency']; ?></option>
                            <?php
                            if (isset($_SESSION['type_currency'])) {
                                echo "<option value=\"\"></option>";
                            }
                            ?>
                            <option value="BYN">BYN</option>
                            <option value="���">���</option>
                            <option value="��">��</option>
                            <option value="EUR">EUR</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>

                    <div class="box" >
                        <select  class="search_bs" name="search_bs" >
                            <option value="<?=$_SESSION['search_bs']; ?>"><?=$_SESSION['search_bs']; ?></option>
                            <option value=""></option>
                            <?php // �������� ����� ���������
                            //                                        $res = mysql_query('SELECT `number` FROM `rent` ORDER BY `number`');
                            $res = mysql_query('SELECT DISTINCT `number` FROM `rent` ORDER BY `number`');
                            while($row2 = mysql_fetch_assoc($res)){
                                ?>
                                <option value="<?php echo $row2['number']; ?>"><?php echo $row2['number']; ?></option>
                            <?php } ?>
                        </select>
                        <label for="search_bs" style="font-weight:bold" title="NE - ����� �������� �������� (��, FTTx, ����, ����)">����� NE</label>
                    </div>

                    <div class="box1 col" >
                        <select class="more_equal" name="more_equal">
                            <option value="<?= $_SESSION['more_equal']; ?>"><?= $_SESSION['more_equal']; ?></option>
                            <option value="=">=</option>
                            <option value=">=">>=</option>
                            <option value="<="><=</option>
                        </select>
                        <input  class="more_equal"  type="text" name="summa_rent" value="<?= $_SESSION['summa_rent']; ?>">
                        <label for="summa_rent" >����� ��������</label>
                    </div>
                </div>
            </div>
        </div>

        </form>
    </div>



    <?php


    If (count($countPage)>=0) {
		
		$arendodatel = 0;
		$arendator = 0;
		
		for ($i=0; $i<count($data); $i++) {                  
			if(!empty($data[$i]['arendodatel'])) {			// ��������� ��������. �������� �� ������� ������ � ������� � ���� ������������
                $arendodatel++;								// ���� ���� ������, �� ���������� ������ ������ ����
            }
			if(!empty($data[$i]['arendator'])) {			// ��������� ��������. �������� �� ������� ������ � ������� � ���� ���������
                $arendator++;								// ���� ���� ������, �� ���������� ������ ������ ����
            }
		}
		
        echo "<div  class=\"container\" >";
        echo "<div class=\"row tablerow\">
   <table>
     <tr>  
        <th class='numberBS'>�����  <br> NE </th>
        <th class='typePlace'>��� <br> ��������</th>
		<th class='adress'>�����</th>";
		If ($arendodatel >0) {                             // ���� ���������� ������ ���� �� �������� ����� ��� ����� ����
        echo "<th class='arendodatel'>������������</th>";
		}
		If ($arendator >0) {
		echo "<th class='arendodatel'>���������</th>";    // ���� ���������� ������ ���� �� �������� ����� ��� ����� ����
		}
		echo
        "<th class='numDogovor'>�����<br/>��������</th>
		<th class='typeDogovor'>��� <br> ��������</th>
		<th class='dataDogovor'>���� <br> ��������</th>
		<th class='dateStart'>������<br/>��������</th>
		<th  class='dateEnd'>�����<br/>��������</th> 
		<th class='typeArendy'>��� <br> ������</th>
		<th class='summa'>�����</th>
		<th class='nds2'>���</th>
		
		<th  class='kontragent'>����������</th>
 		<th  class='worker'>�����������</th>";
        echo"</tr>";
		
		for ($i=0; $i<count($data); $i++) {
        // �������� ������� ������ NE
            if(!empty($data[$i]['number'])){
                $number_NE=$data[$i]['number'];
			}
            else {
                $number_NE='no_numb';
            }
			// �������� ������� ��������
			if(!empty($data[$i]['dogovor_number'])){
                $dog_Num=$data[$i]['dogovor_number'];
            }
            else {
                $dog_Num='��� ������';
            }
            // ����� ������� - �������, ����� ���� ��� ����
            if(!empty($data[$i]['region'])) {
                $regon_out = $data[$i]['region'] . " �������, ";
            }
            else {
                $regon_out="";
            }
            if(!empty($data[$i]['area'])) {
                $area_out = $data[$i]['area'] . " �����, ";
            }
            else {
                $area_out="";
            }
			
			
			$adress_dogovor = $regon_out." ".$area_out." ".$data[$i]['settlement']." ".$data[$i]['adress'];

            echo "<tr>";
            echo "<td><center><b><a href='index.php?Id={$data[$i]['Id']}'>{$number_NE}</a></b></center></td>
                  <td><center>".$data[$i]['type']."</center></td>
                  <td>".$adress_dogovor."</td>";
				  If ($arendodatel >0) {											//�������� ������ �� ������������, ���� ��� ���� ($arendodatel >0)
                  echo "<td><center>".$data[$i]['arendodatel']."</center></td>";
				  }
				  If ($arendator >0) {												//�������� ������ �� ������������, ���� ��� ���� ($arendator >0)
				  echo "<td><center>".$data[$i]['arendator']."</center></td>"; 
				  }
				  echo
                 "<td><center><a href='agreement_list.php?dog=".$dog_Num."'>".$dog_Num."</a></center></td>
                  <td><center>".$data[$i]['dogovor_type']."</center></td> 
                  <td><center>".date("d.m.Y", strtotime($data[$i]['dogovor_date']))."</center></td>
                  <td><center>".date("d.m.Y", strtotime($data[$i]['start_date_dogovor']))."</center></td>
                  <td><center>".date("d.m.Y", strtotime($data[$i]['finish_date_dogovor']))."</center></td> 
                  <td><center>".$data[$i]['type_arenda']."</center></td>
                  <td><center>".$data[$i]['summa']." <br> ".$data[$i]['type_currency']."</center></td>
                  <td><center>".$data[$i]['nds2']." <br> ".$data[$i]['type_currency']."</center></td>
                  <td><center>".$data[$i]['contragent_data']."</center></td>
                  <td><center>".$data[$i]['ispolnitel']."</center></td>";
            echo "</tr>";
        }
    } else {
        echo "<div  class=\"container mt-2\" >
		<h5><span style=\"color:red;\">��������� �� �������</span></h5>
		</div>";
    }
	
    echo "</table>";
    echo "</div>";
    echo "</div>";
	
    ?>
    </div>
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-4 paginat">

                <?php
                // ������� ������ � ������� ������� ��� ������������ ��������
                $array = [];
                for ($i=0; $i < $countPage; $i++){
                    array_push($array, $i);
                }
                // ���� ��� �������� 1 � ���������� �������� � �������
                $new_first = reset($array);
                $new_last = end($array);

                // ������ � ��������� ��� �������
               // $firstElement = array_shift($array);
               // $lastElement = array_pop($array);
				
				 $firstElement = reset($array);
                $lastElement = end($array);

                // ���������� ������� ��������
                if(isset($_GET['page'])){
                    $current = $_GET['page'];
                }
                else{
                    $current=$firstElement;
                }
                // ������ ������
                //                echo count($array);
                $lang = count($array);
                // ������� ��������������
                $Previous = $current - 1;
                $Next=$current + 1;
                if($Previous<0){ $Previous=$current;   }
                if($Next>=$lastElement){  $Next=$lastElement;  }
                if($lang==0){
                    $Next=$current;
                    $lastElement=$current;
                }
                // ����� ������� +1
                $firstElement_d = 1+$firstElement;
                $Previous_d = 1+$Previous;
                $current_d = 1+$current;
                $Next_d = 1+$Next;
                $lastElement_d = 1+$lastElement;
				
				

                echo " <nav aria-label=\"...\">";
                echo "   <ul class=\"pagination\">";
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"geo_finder.php?page=$firstElement\"><sup style=\"color: #0275d8;\">$firstElement_d</sup><img src=\"https://img.icons8.com/color/15/000000/double-left.png\"/></a></li>";
                if ($current_d != 1){ echo " <li class=\"page-item\"><a class=\"page-link\" href=\"geo_finder.php?page=$Previous\">Previous </a></li>";};
                echo " <li class=\"page-item active\">
                        <a class=\"page-link\" href=\"geo_finder.php?page=$current\">$current_d</a>
                        </li>";
                if($current_d != $lastElement+1){
                echo " <li class=\"page-item\"><a class=\"page-link\" href=\"geo_finder.php?page=$Next\">Next </a></li>";};
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"geo_finder.php?page=$lastElement\"><img src=\"https://img.icons8.com/color/15/000000/double-right.png\"/><sup style=\"color: #0275d8;\">$lastElement_d</sup></a></li>";
                echo "   </ul>";
                echo "</nav>";
                ?>
            </div>
			<?php // �������� ������� �� ������ ������� � ���� ������� ��������. ���� ������ �� ������ - �� ����� �������� ���������� ���������� ��������
			If (count($objects)>0) {
			$unique_NE = count(array_unique($objects));
			}
			?>
            <div class="col-7">
                <p style="color: #0275d8; font-size: 14px";>����� <?=count($array_dogovor);?> ��������� �� <?=$summarow?> NE 
					<?php If (count($objects)>0) {
						echo "(���������� �������� ".$unique_NE.")"; //����� ���������� ���������� �������� ���� ����� ������ ���������� ����������� � �� ������
						} ?>
                    <?php echo " �� ����� :" . " <br>";

                    if ($BYN>0){
                        echo "$BYN BYN � �.�.  $BYN_NDS ���; <br>";
                    }
                    if ($EUR>0){
                        echo"$EUR EUR � �.�. $EUR_NDS ���; <br>";
                    }
                    if ($USD>0){
                        echo" $USD USD � �.�. $USD_NDS ���; <br>";
                    }
                    if ($BAV>0){
                        echo"$BAV ��� � �.�. $BAV_NDS ���; <br>";
                    }
                    if ($BV>0){
                        echo"$BV �� � �.�. $BV_NDS ���";
                    }
					unset ($unique_NE); //�������� ���������� $unique_NE, ���� �� ����������� ������ Coockie
                    ?></p>
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