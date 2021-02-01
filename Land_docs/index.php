<?php
include_once('/core/config.php');
include_once('/core/function.php');
include_once('../config.php');
session_start();

// ������� ����
$today = date("Y-m-d");
//���� + 3 ������
$today3 = date("Y-m-d",mktime(0, 0, 0, date("m")+3,   date("d"),   date("Y")));

// ����� ������� � ����
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

//���������� ���������� �����, ������� � ��� �����, ��� ������, ������������, ���������
if (isset($_POST['bts'])) { //(������������ ��� �� �����)
    $bts = $_POST['bts'];
    $_SESSION['bts'] = $bts;
} else {
    $bts = '';
}
// ����� ������� ��� ������ � �� ������
IF ($_SESSION['reg_user'] == '�����') {
	if (isset($_POST['oblast'])) { //(������������ ��� �� �����)
		$_SESSION['oblast'] = $_POST['oblast'];
	} 
} else {
	if ($_SESSION['reg_user'] == '����') {
		$_SESSION['oblast'] = '�������';
		//$_POST['oblast'] = '�������';
	} else {
		$_SESSION['oblast'] = $_SESSION['reg_user'];
		//$_POST['oblast'] = $_SESSION['reg_user'];
	}
}


if (isset($_POST['raion'])) { //(������������ ��� �� �����)
    $raion = $_POST['raion'];
    $_SESSION['raion'] = $raion;
} else {
	$raion = '';
}

// ������� �� ������ (������������ ��� �� �����)
if (isset($_POST['nas_punkt'])) {
    $nas_punkt = clean ($_POST['nas_punkt']);
    $_SESSION['nas_punkt'] = $nas_punkt;
} else {
    $city = "";
}

// ��� ������ (����������� � � ������)
if (isset($_POST['type_pravo'])) { //(������������ ��� �� �����)
    $type_pravo = $_POST['type_pravo'];
    $_SESSION['type_pravo'] = $type_pravo;
} else {
    $type_pravo = '';
}

if (isset($_POST['kadastroviy_number'])) { //(������������ ��� �� �����)
    $kadastroviy_number = clean ($_POST['kadastroviy_number']);
    $_SESSION['kadastroviy_number'] = $kadastroviy_number;

} else {
    $kadastroviy_number = '';
}

// ������� �� ������������ ������ ���. ������� (������������ ��� �� �����)
if (isset($_POST['inventarniy_building'])) {
    $inventarniy = clean ($_POST['inventarniy_building']);
    $_SESSION['inventarniy_building'] = $inventarniy;
} else {
    $inventarniy = "";
}

// ���� ���������
if (isset($_POST['dogovor_start_1'])) {    //(������������ ��� �� �����)
    $dogovor_start_1 = $_POST['dogovor_start_1'];
    $_SESSION['dogovor_start_1'] = $dogovor_start_1;
} else {
    $dogovor_start_1 = '';
}

if (isset($_POST['dogovor_start_2'])) {    //(������������ ��� �� �����)
    $dogovor_start_2 = $_POST['dogovor_start_2'];
    $_SESSION['dogovor_start_2'] = $dogovor_start_2;
} else {
    $dogovor_start_2 = '';
}

if (isset($_POST['dogovor_finish_1'])) {   //(������������ ��� �� �����)
    $dogovor_finish_1 = $_POST['dogovor_finish_1'];
    $_SESSION['dogovor_finish_1'] = $dogovor_finish_1;
} else {
    $dogovor_finish_1 = '';
}
if (isset($_POST['dogovor_finish_2'])) {   //(������������ ��� �� �����)
    $dogovor_finish_2 = $_POST['dogovor_finish_2'];
    $_SESSION['dogovor_finish_2'] = $dogovor_finish_2;
} else {
    $dogovor_finish_2 = '';
}

//������ ��������
if (isset($_POST['type_currency'])) {   //(������������ ��� �� �����)
    $type_currency = $_POST['type_currency'];
    $_SESSION['type_currency'] = $type_currency;
} else {
    $type_currency = '';
}

//  ���������� ������ �� �������� ������ (������������ ��� �� �����)
if (isset($_POST['adsearch'])) {
    $adsearch = clean ($_POST['adsearch']);
    $_SESSION['adsearch'] = $adsearch;
} else {
    $adsearch = "";
}


//  �� ������ �������� ������ (������������ ��� �� �����)
if (isset($_POST['dogovor_number'])) {
    $dogovor_number = clean ($_POST['dogovor_number']);
    $_SESSION['dogovor_number'] = $dogovor_number;
} else {
    $dogovor_number = "";
}

// ���� ��������    (������������ ��� �� �����)
if (!empty($_POST['dogovor_date'])) {
    $dogovor_date = $_POST['dogovor_date'];
    $_SESSION['dogovor_date'] = $dogovor_date;
} else {
    $dogovor_date = "";
}

// ������� �� �����������  (������������ ��� �� �����)
if (isset($_POST['ispolnitel'])) {
    $ispolnitel = ($_POST['ispolnitel']);
    $_SESSION['ispolnitel'] = $ispolnitel;
} else {
    $ispolnitel = "";
}

// ������� �� �����������  (������������ ��� �� �����)
if (isset($_POST['type_opori'])) {
    $type_opori = clean ($_POST['type_opori']);
    $_SESSION['type_opori'] = $type_opori;
} else {
    $type_opori = "";
}

//  �� ��������� ��������     (������������ ��� �� �����)
if (isset($_POST['summa_rent'])) {
    $summa_rent = ($_POST['summa_rent']);
    $_SESSION['summa_rent'] = $summa_rent;
} else {
    $summa_rent = "";
}

if (!empty($_POST['more_equal'])) {  //(������������ ��� �� �����)
    $more_equal = $_POST['more_equal'];
    $_SESSION['more_equal'] = $more_equal;
}

//������� ������������� ������
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

$conn = connect(); // ����������� � ��

$data = []; // �������� ������, � ������� ����� �������� ������ �� �������

//����� ������ �� � ����������� �� �������		
$_SESSION['bts'] = $_POST['bts'];

function counter_string($conn){ //������� ���������� ����� (�������/����������)
    	
    $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
    If (!empty($_SESSION['oblast'])) { //������ �� �������
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //������ �� ������
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //������ �� ��� ������
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //������ �� ������ ��
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //������ �� ������ �������� ������
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //������ �� ���� �������� ������
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //������ �� ���� ������� �����
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //������ �� �����������
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //������ �� ���� �����
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //������ �� ������������ ������
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { //������ �� ������������ ������
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //������ �� ���� ������ �������� ��������
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //������ �� ���� ��������� �������� ��������
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //������ �� ���� ������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //������ �� ����� ��������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row;
			
	}
	return count($a); //���������� ����� ������� � �������
	
}

//����� ������ �� ������� � ���� �������
function select($conn){ //���������
    $offset = 0;
    if (isset($_GET['page']) AND trim($_GET['page']) !== '') {
        $offset = trim($_GET['page']);    }
		
	
		
	
    $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
	
	If (!empty($_SESSION['oblast'])) { //������ �� �������
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //������ �� ������
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //������ �� ��� ������
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //������ �� ������ ��
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //������ �� ������ �������� ������
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //������ �� ���� �������� ������
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //������ �� ���� ������� �����
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //������ �� �����������
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //������ �� ���� �����
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //������ �� ������������ ������
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { //������ �� ������������ ������
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //������ �� ���� ������ �������� ��������
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //������ �� ���� ��������� �������� ��������
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //������ �� ���� ������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //������ �� ����� ��������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row;
			
	}
	return $a;
	
}

$data = select ($conn); //���������� ������ ������� � ������� ������� � ������ DATA

function paginationCount($conn) //���� ���������� ������� � ��������� �� 10 �����
{
   
     $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
    If (!empty($_SESSION['oblast'])) { //������ �� �������
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //������ �� ������
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //������ �� ��� ������
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //������ �� ������ ��
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //������ �� ������ �������� ������
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //������ �� ���� �������� ������
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //������ �� ���� ������� �����
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //������ �� �����������
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //������ �� ���� �����
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //������ �� ������������ ������
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { //������ �� ������������ ������
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //������ �� ���� ������ �������� ��������
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //������ �� ���� ��������� �������� ��������
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //������ �� ���� ������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //������ �� ����� ��������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
    $summarow = $result;  // ����� ����� - ������� � �������
    return ceil($summarow / 10);
		
}

// ������ ���������� ������� ��� 10 ����� �� ��������
$countPage = paginationCount($conn);

function data_no_pagination ($conn){ //������� ���������� ����� (�������/����������)
    	
    $sql = "SELECT * FROM  land_docs_minsk WHERE Id IS NOT NULL";
   If (!empty($_SESSION['oblast'])) { //������ �� �������
	    $sql .= " AND oblast like '" . $_SESSION['oblast'] . "' ";
    }
	If (!empty($_SESSION['raion'])) { //������ �� ������
	    $sql .= " AND raion like '" . $_SESSION['raion'] . "' ";
    }
	If (!empty($_SESSION['nas_punkt'])) { //������ �� ��� ������
	    $sql .= " AND nas_punkt like '%" . $_SESSION['nas_punkt'] . "%' ";
    }
    If (!empty($_SESSION['bts'])) { //������ �� ������ ��
        $sql .= " AND bts like '" . $_SESSION['bts'] . "' ";
    }
	If (!empty($_SESSION['dogovor_number'])) { //������ �� ������ �������� ������
        $sql .= " AND dogovor_number like '" . $_SESSION['dogovor_number'] . "' ";
    }
	If (!empty($_SESSION['dogovor_date'])) { //������ �� ���� �������� ������
        $sql .= " AND dogovor_date like '" . $_SESSION['dogovor_date'] . "' ";
    }
	If (!empty($_SESSION['type_pravo'])) { //������ �� ���� ������� �����
        $sql .= " AND type_rent like '" . $_SESSION['type_pravo'] . "' ";
    }
	If (!empty($_SESSION['ispolnitel'])) { //������ �� �����������
        $sql .= " AND ispolnitel like '" . $_SESSION['ispolnitel'] . "' ";
    }
	If (!empty($_SESSION['type_opori'])) { //������ �� ���� �����
        $sql .= " AND type_opori like '%" . $_SESSION['type_opori'] . "%' ";
    }
	If (!empty($_SESSION['kadastroviy_number'])) { //������ �� ������������ ������
        $sql .= " AND kadastroviy_number like '" . $_SESSION['kadastroviy_number'] . "' ";
    }
	If (!empty($_SESSION['inventarniy_building'])) { //������ �� ������������ ������
        $sql .= " AND inventarniy_building like '" . $_SESSION['inventarniy_building'] . "' ";
    }
	If (!empty($_SESSION['dogovor_start_1']) AND !empty($_SESSION['dogovor_start_2'])) { //������ �� ���� ������ �������� ��������
        $sql .= " AND dogovor_start BETWEEN '" . $_SESSION['dogovor_start_1'] . "' AND '" . $_SESSION['dogovor_start_2'] . "' ";
    }
    If (!empty($_SESSION['dogovor_finish_1']) AND !empty($_SESSION['dogovor_finish_2'])) { //������ �� ���� ��������� �������� ��������
        $sql .= " AND dogovor_finish BETWEEN '" . $_SESSION['dogovor_finish_1'] . "' AND '" . $_SESSION['dogovor_finish_2'] . "' ";
    }
	If (!empty($_SESSION['type_currency'])) { //������ �� ���� ������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` is not NULL";
    }
	If (!empty($_SESSION['summa_rent']) AND !empty($_SESSION['more_equal']) AND !empty($_SESSION['type_currency'])) { //������ �� ����� ��������
        $sql .= " AND `rent_".$_SESSION['type_currency']."` ".$_SESSION['more_equal']." ".$_SESSION['summa_rent'];
    }
	If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row;
			
	}
	return $a; //���������� ����� ������� � �������
	
}

// ������ ���������� ����� ��������� � �������
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
    <title>��������� �� �����</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
    <link rel="stylesheet" href=" bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href=" ../rent/Style.css">
    <script defer src="../rent/script.js"></script>

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
                            if ($user_id == 0) { //����� ��� ����� ������������
                                include('login_form.php');
                            }
                            if ($user_id > 0) { //����� ������ ���������� � ������������
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
					<h4>���� ���������� �� ��������� �������</h4>
<?php If ($user_id > 0) {  //���� ����������� - �� ��� �������� � ����������  ?>					
					
                        <div class="row align-items-center ">
							<div class="col-md-3 push-1">
                                <form action="index.php" method="post">
                                  <div class="pressMe" >
									<input type="submit" name="table_gen" type="button" class="btn btn-danger" value="�����" title="��������� �� ��������">
									</div>
							</div>
							<div class="col-md-3" >
								<a href="loadExcel.php" target="_blank" title="��������� � Excel"><button type="button" class="btn btn-danger" >��������� � EXCEL</button></a>
							</div>
							<div class="col-md-2" >
								<?php If ($_SESSION['rights'] == 'w') { ?>
									<a href="new_bs.php" target="_blank"><button type="button" class="btn btn-danger" >NEW_NE</button></a>
								<?php } ?>
							</div>
							<div class="col-md-2" >
								<img  title="���������� �������" id="buttonshow" src='../rent/images/icons8_100.png' >
								<a id="areset" href="reset.php" ><img  title="�������� �������" id="reset" src="/rent/images/reset_icon.svg"></a>
							</div>
							<div class="col-md-2" >
								<a href="../main.php" title="����� ��"><button type="button" class="btn btn-danger" >����� ��</button></a>
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
                        <label for="oblast">�������</label>
						<select  class="reg_oblast" name="oblast">
							<?php If ($_SESSION['reg_user'] == '�����') { 
								echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								echo "<option value=\"\"></option>";
								echo "<option value=\"�������\">�������</option>";
								echo "<option value=\"���������\">���������</option>";
								echo "<option value=\"���������\">���������</option>";
								echo "<option value=\"����������\">����������</option>";
								echo "<option value=\"�����������\">�����������</option>";
								echo "<option value=\"�����������\">�����������</option>";
							} else { 
								IF ($_SESSION['reg_user'] == '����') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == '���������') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == '���������') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == '����������') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == '�����������') {
									echo "<option value=\"\"></option>";
									echo "<option value=".$_SESSION['oblast'].">".$_SESSION['oblast']."</option>";
								}
								IF ($_SESSION['reg_user'] == '�����������') {
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
							  //������� �������� ���� �� � ���� ��� ��������
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
							<label for="bts">����� NE</label>
					</div>
                     <div class="box1 col-md-6">
                        <select class="selectDistributs" name="raion"></select>
						<label for="raion">�����</label>
                    </div>
                    <div class="box1 col-md-6" >
                            <input  type="text" name="dogovor_number" value="<?= $_SESSION['dogovor_number']; ?>">
                            <label for="dogovor_number" >����� ��</label>
                    </div>
                    <div class="box1 col-md-6">
                        <input type="text" name="nas_punkt" value="<?= $_SESSION['nas_punkt']; ?>">
                        <label for="nas_punkt">���. �����</label>
                    </div>
                    <div class="box1 col-md-6">
                        <input  type="date" name="dogovor_date" value="<?=$_SESSION['dogovor_date']?>">
                        <label for="dogovor_date">���� ��</label>
                    </div>
                </div>
            </div>
			<div class="col-4 order-first">
                <div class="box1 col" >
                    <select  class="type_dogovor search_bs" name="type_pravo" >
						<option value="<?=$_SESSION['type_pravo']; ?>"><?=$_SESSION['type_pravo']; ?></option>
						<?php // �������� ����� ���������
                         $res = mysql_query('SELECT DISTINCT `type_rent` FROM `land_docs_minsk` ORDER BY `type_rent`');
                        while($row2 = mysql_fetch_assoc($res)){
                            ?>
                            <option value="<?php echo $row2['type_rent']; ?>"><?php echo $row2['type_rent']; ?></option>
                        <?php } ?>

                    </select>
                    <label for="type_pravo">������ �����</label>
                </div>
				<div class="box1 col" >
                    <input  type="text" name="kadastroviy_number" value="<?= $_SESSION['kadastroviy_number']; ?>">
                    <label for="kadastroviy_number" >����������� � �� </label>
                </div>
                <div class="box1 col" >
                    <input  type="text" name="inventarniy_building" value="<?= $_SESSION['inventarniy_building']; ?>">
                    <label for="inventarniy_building" >����������� � �� </label>
                </div>
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
                x.setAttribute("name", "raion");
                // distr.appendChild(x);
                // ��������   option
                let z = document.createElement("option");
                console.log(z);
                z.setAttribute("value", "");
                let t = document.createTextNode("<?=$_SESSION['raion']; ?>");
                z.appendChild(t);
                document.getElementById("mySelect").appendChild(z);
				console.log(document.getElementById("mySelect").appendChild(z));

                // ������� onchange  ����������� �� ��������� ��������
                document.querySelector('.reg_oblast').onchange = function () {
                    // �������� ������� � ���������� selectRegion
                    let option = document.querySelectorAll('.reg_oblast option');
                    console.log(option);
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
                    <p>���� ������ ��</p>
                    <div class="box2" >
                        <input  type="date" name="dogovor_start_1" value="<?=$_SESSION['dogovor_start_1']?>" >
                        <label for="dogovor_start_1">�:&nbsp;</label>
                    </div>
                    <div class="box2" >
                        <input  type="date" name="dogovor_start_2" value="<?=$_SESSION['dogovor_start_2']?>" >
                        <label for="dogovor_start_2" >��:&nbsp;</label>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="datebox">
                    <p>���� ��������� ��</p>
                    <div class="box2  " >
                        <input  type="date" name="dogovor_finish_1" value="<?=$_SESSION['dogovor_finish_1']?>" >
                         <label for="dogovor_finish_1">�:&nbsp;</label>
                    </div>
                    <div class="box2 " >
                        <input  type="date" name="dogovor_finish_2" value="<?=$_SESSION['dogovor_finish_2']?>" >
                        <label for="dogovor_finish_2" >��:&nbsp;</label>
                    </div>
                </div>
            </div>
            <div class="col-4">
                    <div class="datebox">
						<div class="box1 col">
                            <input id = "keyword" type="text" name="adsearch" title="����� �� ����� ������������ (����� ��, �����, ��� �����, �����������, ����������)" value="<?=$_SESSION['adsearch'];?>">
                            <label for="adsearch">�������� �����</label>
                        </div> 

                        <div class="box ">
                            <select  class="box" name="ispolnitel" >
								<option value="<?=$_SESSION['ispolnitel']; ?>"><?=$_SESSION['ispolnitel']; ?></option>
							<?php // �������� ������������
								$res = mysql_query('SELECT DISTINCT `ispolnitel` FROM `land_docs_minsk` ORDER BY `ispolnitel`');
								while($row2 = mysql_fetch_assoc($res)){
                            ?>
								<option value="<?php echo $row2['ispolnitel']; ?>"><?php echo $row2['ispolnitel']; ?></option>
							<?php } ?>
							</select>
                            <label for="ispolnitel">�����������</label>
                        </div>
						<div class="box ">
							<input class="box" type="text" name="type_opori" value="<?=$_SESSION['type_opori']; ?>">
                            <!-- <select  class="box" name="type_opori" >
								<option value="<?=$_SESSION['type_opori']; ?>"><?=$_SESSION['type_opori']; ?></option>
							<?php // �������� ������������
								$res = mysql_query('SELECT DISTINCT `type_opori` FROM `land_docs_minsk` ORDER BY `type_opori`');
								while($row2 = mysql_fetch_assoc($res)){
                            ?>
								<option value="<?php echo $row2['type_opori']; ?>"><?php echo $row2['type_opori']; ?></option>
							<?php } ?>
							</select> -->
                            <label for="type_opori">��� �����</label>
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
                        <label for="summa_rent" >����� ��������</label>
                    </div>
                </div>
            </div>
        </div>

        </form>
    </div>
	
<?php

    //����� ������ � ������� ���� ������ � ������� DATA �� ������
     If (count($countPage)>=0) {
        echo "<div  class=\"container\" >"; // ����� �������
        echo "<div class=\"row tablerow\">
   <table>
     <tr>
		<th class='bts_land'>PDF</th>	 
        <th class='bts_land'>������</th>
		<th class='bts_land'>�����</th>
		<th class='bts_land'>���<br/>�����</th>
		<th class='bts_land'>C�����-��<br/>���. ���. ��</th>
		<th class='bts_land'>����������� � ��</th>
		<th class='bts_land'>������� ��<br/>(��)</th>
		<th class='bts_land'>������<br/>�����</th>
		<th class='bts_land'>�������<br/>��</th>
		<th class='bts_land'>����������� � ��</th>
		<th class='bts_land'>�������������<br/>���. ���. ��</th>
		<th class='bts_land'>������� ������</th>
		<th class='bts_land'>���� ��������<br/>��</th>
		<th class='bts_land'>�����������</th>
	 </tr>"; 
		echo "<tr>";  //����� ������ � �������
        for ($i=0; $i<count($data); $i++) {
        // �������� ������� ������ NE
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
				//$resheniye_videlenie = $data[$i]['resheniye_videlenie'];  			//���� ����� �� �����
				//$resheniye_videlenie_date = $data[$i]['resheniye_videlenie_date'];	//���� ����� �� �����
				//$razreshenie_number = $data[$i]['razreshenie_number'];				//���� ����� �� �����
				//$razreshenie_number_date = $data[$i]['razreshenie_number_date'];		//���� ����� �� �����
				$notes = $data[$i]['notes'];
				$ispolnitel = $data[$i]['ispolnitel'];
				
				$type_link = "_��";
				
				$link = "scans_docs/".$oblast."/".$bts.$type_link.".pdf"; //������������ ���� � ��������� � ������
				
				If (file_exists($link) == TRUE) {
					echo "<td span style=\"padding: 5px;\"><b><a href='$link' target='_blank'><img src='../pics/info_picc.png' width='20px'></a></b></td>";
				} else {
					echo "<td span style=\"padding: 5px;\"></td>";
				}
				echo "<td><center><b><a href='dogovor.php?Id=$Id'>".$bts."</a></b></center></td>";
				echo "<td span style=\"padding: 5px;\">".$oblast." ���.,<br/> ".$raion." �-�,<br/> ".$nas_punkt;
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
				
				// ���������� � ����� ������� �� �������� �� ��������
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
				unset ($pay); // ����������� ���� �������� ����������, ���� ��� �� ������� �� ������ ������ ��� ������!!!
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
							echo "<br/>�� <br/><span style=\"color:red;\">".$dogovor_finish."</td>";
						} else {
							IF ($dogovor_finish > $today AND $dogovor_finish < $today3) {
								echo "<br/>�� <br/><span style=\"color:blue;\">".$dogovor_finish."</td>";
							} else {
								echo "<br/>�� <br/>".$dogovor_finish."</td>";
							}
						}
					}
				echo "</td>";
				echo "<td span style=\"padding: 5px;font-size: 10px;\">".$ispolnitel."</td>";				
				//echo "<td span style=\"padding: 5px;\">".$resheniye_videlenie."<br/>�� ".$resheniye_videlenie_date."</td>";
				//echo "<td span style=\"padding: 5px;\">".$razreshenie_number."<br/>�� ".$razreshenie_number_date."</td>";
				//echo "<td span style=\"padding: 5px;\">".$notes."</td>";
				
			
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
   
           
        </div>
    </div>
	
<div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-5 paginat">

                <?php
                // ������� ������ � ������� ������� ��� ������������ ��������
                $array = [];
                for ($i=0; $i < $countPage; $i++){
                    array_push($array, $i);
                }
                // ���� ��� �������� 1 � ���������� �������� � �������
                $new_first=reset($array); //������������� ����� �������� �� ������ (������ �������)
                $new_last = end($array); //������������� �������� �� ��������� (���������� ������� -1)

                // ������ � ��������� ��� �������
                //$firstElement = array_shift($array); // ��������� ������ ������� ������� ������� �������
                //$lastElement = array_pop($array); //��������� ��������� ������� ������� ������� �������

                // ���������� ������� ��������
                if(isset($_GET['page'])){  //��� ������� �������� �� ������ ����� 1��, ����� ��������� ���� ����� ����������
                    $current = $_GET['page'];
                }
                else{
                    $current=$new_first; //����� ��������� ����� ������ �������� (����)
                }
				
				$_SESSION['page'] = $current; //������ � ������ ������ ��������, ��������� �� �������, ���� �� ��� ��������� �� ��������
				
                // ������ ������
                //                echo count($array);
                $lang = count($array); //����� ������� = ���������� �������
                // ������� ��������������
                $Previous = $current - 1;
                $Next=$current + 1;
                if($Previous<0){ $Previous=$current;   }
                if($Next>=$new_last){  $Next=$new_last;  }
                if($lang==0){  //���� ������� ���, ������ ������ �� �������
                    $Next=$current;
                    $new_last=$current;
                }
                // ����� ������� +1
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
                <tr style="color: #0275d8; font-size: 14px";><td>������� ���������� (�����)</td><td><b><?php $counter = counter_string ($conn); echo $counter; ?></b></td></tr>
				<tr style="color: #0275d8; font-size: 14px";><td>C�������� ������� (��)</td><td><b><?php echo $summ_land; ?></b></td></tr>
				<tr style="color: #0275d8; font-size: 14px";><td>����� ����� (BYN)</td><td><b><?php echo $summ_BYN; ?></b></td></tr>
				<tr style="color: #0275d8; font-size: 14px";><td>����� ����� (USD)</td><td><b><?php echo $summ_USD; ?></b></td></tr>
				</table>
            </div>
        </div>
    </div>
<?php } ?>


</body>
</html>


