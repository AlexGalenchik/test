<?php
session_start();
include_once('../config.php');
include_once('../functions.php');
include_once('./core/function.php');

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

$dog_number = $_GET['dog']; //��� �������� ������ �� ���������� ��������
$_SESSION['dog'] = $dog_number; //������� � ������ ��� �������� ������


//var_dump($_SESSION['dog']);

//  ����������� � �� - � ����� ���� ��� ���� ������� ����������� � ��
function connect()
{
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'mts_dbase');
    // ���������
    mysqli_set_charset($conn, "cp1251");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

$conn = connect();



//����� ������ �� ������� � ���� �������
function select($conn){ //���������
    $offset = 0;
    if (isset($_GET['page']) AND trim($_GET['page']) != '') {
        $offset = trim($_GET['page']);
    }

   	 // ��������� ������ �� ��
        If ($_SESSION['reg_user'] == '�����') { //���� ����� �������������, �� �� ������ ������ ��� �������
            $sql = "SELECT * FROM  rent WHERE Id is not NULL";
            If (!empty($_SESSION['reg'])) { //������ �� ������� - ���� ������������� ������ ���� �� ��������
                $sql .= " AND region like '".$_SESSION['reg']."' ";}

        } else {
            $sql = "SELECT * FROM  rent WHERE region like '".$_SESSION['reg_user']."'"; //���� ��� �� �������������, �� �� ����� ������ ���� �������
        }

        If (!empty($_SESSION['Areas'])) { //������ �� ������
            $sql.=" AND area like '".$_SESSION['Areas']."' ";}
        If (!empty($_SESSION['type_dogovor'])) { //������ �� ���� ��������
            $sql.=" AND type_arenda like '".$_SESSION['type_dogovor']."' ";
		}
		If (!empty($_SESSION['dogovor_type'])) { //������ �� ���� ��������
			$sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
		}
			
        If (!empty($_SESSION['arendodatel'])) { // ������ �� ������������
            $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
        }
        If (!empty($_SESSION['search_bs'])) { //������ �� ������ ��
            $sql.=" AND number like '".$_SESSION['search_bs']."' ";}
			
        If (!empty($_SESSION['type_bs'])) { //������ �� ���� �������� ///////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		
    }

        If (!empty($_SESSION['type_currency'])) { //������ �� ���� ������
            $sql.=" AND type_currency like '".$_SESSION['type_currency']."' ";}

        If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2']) ){ //������ �� ���� ������ �������� ��������
            $sql.=" AND start_date_dogovor BETWEEN '".$_SESSION['start_date_1']."' AND '".$_SESSION['start_date_2']."' ";}

        If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4']) ){ //������ �� ���� ��������� �������� ��������
            $sql.=" AND finish_date_dogovor BETWEEN '".$_SESSION['start_date_3']."' AND '".$_SESSION['start_date_4']."' ";}

        $sql .= " AND `dogovor_number` LIKE '".$_GET['dog']."' ";//����� ������� �� ������ �������� (�������� 23.10.2020)

        If (!empty($_SESSION['summa_rent'])) { //������ �� ����� ��������
            $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
        }

        If (!empty($_SESSION['city'])) {
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
        }
        If (!empty($_SESSION['woker'])) { //������ �� ������ ��������
            $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
        }

        If (!empty($_SESSION['division'])) { //������ �� �������������
            $sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
        }

        If (!empty($_SESSION['data_dog'])) { //������ ���� ��������
            $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
        }
		
		If (!empty($_SESSION['reg_user']) AND $_SESSION['reg_user'] != '�����') { //������ ������������� ������ ��������� �������� 30.07.2020
			$sql .= " AND division LIKE '" . $_SESSION['reg_user'] . "'   ";
		}
		
		If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
	$sql .= " ORDER BY number LIMIT 10 OFFSET " . $offset * 10;
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
                $sql .= " AND region like '".$_SESSION['reg']."' ";}

        } else {
            $sql = "SELECT * FROM  rent WHERE region like '".$_SESSION['reg_user']."'"; //���� ��� �� �������������, �� �� ����� ������ ���� �������
			$sql .= " AND dogovor_number LIKE '".$_GET['dog']."' ";//����� ������� �� ������ �������� (�������� 23.10.2020)
        }

        If (!empty($_SESSION['Areas'])) { //������ �� ������
            $sql.=" AND area like '".$_SESSION['Areas']."' ";}
        If (!empty($_SESSION['type_dogovor'])) { //������ �� ���� ��������
            $sql.=" AND type_arenda like '".$_SESSION['type_dogovor']."' ";
		}
		If (!empty($_SESSION['dogovor_type'])) { //������ �� ���� ��������
			$sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
		}
        If (!empty($_SESSION['arendodatel'])) { // ������ �� ������������
            $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
        }
        If (!empty($_SESSION['search_bs'])) { //������ �� ������ ��
            $sql.=" AND number like '".$_SESSION['search_bs']."' ";}
			
        If (!empty($_SESSION['type_bs'])) { //������ �� ���� �������� ///////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		
		}

        If (!empty($_SESSION['type_currency'])) { //������ �� ���� ������
            $sql.=" AND type_currency like '".$_SESSION['type_currency']."' ";}

        If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2']) ){ //������ �� ���� ������ �������� ��������
            $sql.=" AND start_date_dogovor BETWEEN '".$_SESSION['start_date_1']."' AND '".$_SESSION['start_date_2']."' ";}

        If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4']) ){ //������ �� ���� ��������� �������� ��������
            $sql.=" AND finish_date_dogovor BETWEEN '".$_SESSION['start_date_3']."' AND '".$_SESSION['start_date_4']."' ";}

        //If (!empty($_SESSION['num_rent'])) { //������ �� ������ ��������
        //    $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
        //}

        If (!empty($_SESSION['summa_rent'])) { //������ �� ����� ��������
            $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
        }

        If (!empty($_SESSION['city'])) {
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
        }
        If (!empty($_SESSION['woker'])) { //������ �� ������ ��������
            $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
        }

        If (!empty($_SESSION['division'])) { //������ �� �������������
            $sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
        }

        If (!empty($_SESSION['data_dog'])) { //������ ���� ��������
            $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
        }
		
		If (!empty($_SESSION['reg_user']) AND $_SESSION['reg_user'] != '�����') { //������ ������������� ������ ��������� �������� 30.07.2020
			$sql .= " AND division LIKE '" . $_SESSION['reg_user'] . "'   ";
		}
		
		If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
for ($i = 0; $i <= count($dataCurrency); $i++) {
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
    // ��������� ������ �� ��
        If ($_SESSION['reg_user'] == '�����') { //���� ����� �������������, �� �� ������ ������ ��� �������
            $sql = "SELECT * FROM  rent WHERE Id is not NULL";
            If (!empty($_SESSION['reg'])) { //������ �� ������� - ���� ������������� ������ ���� �� ��������
                $sql .= " AND region like '".$_SESSION['reg']."' ";}

        } else {
            $sql = "SELECT * FROM  rent WHERE region like '".$_SESSION['reg_user']."'"; //���� ��� �� �������������, �� �� ����� ������ ���� �������
        }

        If (!empty($_SESSION['Areas'])) { //������ �� ������
            $sql.=" AND area like '".$_SESSION['Areas']."' ";}
        If (!empty($_SESSION['type_dogovor'])) { //������ �� ���� ��������
            $sql.=" AND type_arenda like '".$_SESSION['type_dogovor']."' ";
		}
		If (!empty($_SESSION['dogovor_type'])) { //������ �� ���� ��������
			$sql .= " AND dogovor_type like '" . $_SESSION['dogovor_type'] . "' ";
		}
        If (!empty($_SESSION['arendodatel'])) { // ������ �� ������������
            $sql .= " AND arendodatel like '%" . $_SESSION['arendodatel'] . "%'";
        }
        If (!empty($_SESSION['search_bs'])) { //������ �� ������ ��
            $sql.=" AND number like '".$_SESSION['search_bs']."' ";}
			
        If (!empty($_SESSION['type_bs'])) { //������ �� ���� �������� ///////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		
    }

        If (!empty($_SESSION['type_currency'])) { //������ �� ���� ������
            $sql.=" AND type_currency like '".$_SESSION['type_currency']."' ";}

        If (!empty($_SESSION['start_date_1']) AND !empty($_SESSION['start_date_2']) ){ //������ �� ���� ������ �������� ��������
            $sql.=" AND start_date_dogovor BETWEEN '".$_SESSION['start_date_1']."' AND '".$_SESSION['start_date_2']."' ";}

        If (!empty($_SESSION['start_date_3']) AND !empty($_SESSION['start_date_4']) ){ //������ �� ���� ��������� �������� ��������
            $sql.=" AND finish_date_dogovor BETWEEN '".$_SESSION['start_date_3']."' AND '".$_SESSION['start_date_4']."' ";}

        //If (!empty($_SESSION['num_rent'])) { //������ �� ������ ��������
        //    $sql .= " AND dogovor_number LIKE '%" . $_SESSION['num_rent'] . "%'   ";
        //}

        If (!empty($_SESSION['summa_rent'])) { //������ �� ����� ��������
            $sql .= " AND summa " . $_SESSION['more_equal'] . "  '" . $_SESSION['summa_rent'] . "'   ";
        }

        If (!empty($_SESSION['city'])) {
            $sql .= " AND settlement LIKE '%" . $_SESSION['city'] . "%'   ";
        }
        If (!empty($_SESSION['woker'])) { //������ �� ������ ��������
            $sql .= " AND ispolnitel LIKE '%" . $_SESSION['woker'] . "%'   ";
        }

        If (!empty($_SESSION['division'])) { //������ �� �������������
            $sql .= " AND division LIKE '" . $_SESSION['division'] . "'   ";
        }

        If (!empty($_SESSION['data_dog'])) { //������ ���� ��������
            $sql .= " AND dogovor_date LIKE '" . $_SESSION['data_dog'] . "'   ";
        }
		
		If (!empty($_SESSION['reg_user']) AND $_SESSION['reg_user'] != '�����') { //������ ������������� ������ ��������� �������� 30.07.2020
			$sql .= " AND division LIKE '" . $_SESSION['reg_user'] . "'   ";
		}
		If (!empty($_GET['dog'])) {
			$sql .= " AND dogovor_number LIKE '".$_GET['dog']."' ";//����� ������� �� ������ �������� (�������� 23.10.2020)
		}
	

        If (!empty($_SESSION['adsearch'])) { //������ �� ��������� �����
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
    $summarow = $result;
    return ceil($result / 10);
}

$countPage = paginationCount($conn);


?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " />
    <!--     <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>������� � <?php echo $dog_number; ?></title>
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
                        <div class="row align-items-center ">
                            <div class="col-md-3 push-1">
                               <a href="/rent/geo_finder.php"><button type="button" class="btn btn-danger" >�����</button></a> 
                                    
                            </div>

                            <div class="col-md-3  arend">
                                <a href="loadExcelDog.php?dog=<?php echo $dog_number; ?>" target="_blank"><button type="button" class="btn btn-danger" >��������� � EXCEL</button></a>
                            </div>
                            <div class="col-md-3  arend">
<!--                                <button type="button" id="buttonshow" class="btn btn-danger">���������� �������</button>-->
<!--                                <a href="report.php" target="_blank"><button type="button" class="btn btn-danger" >������</button></a>-->

                            </div>
                            <div class="col-md-3  arend">
<!--                                <a href="reset.php" ><button type="button" class="btn btn-danger" >�������� �������</button></a>-->
<!--                                <img  title="���������� �������" id="buttonshow" src='./images/icons8_100.png' >-->
<!--                                <a id="areset"   href="reset.php" > <img  title="�������� �������" id="reset" src="./images/reset_icon.svg" > </a>-->
                            </div>
                        </div>
                    </div>
                </div>		<!-- ����� ����� ����������� -->
            </div> <!-- row 2 -->
        </div><!-- 2 container -->
    </div><!-- row col-12 -->
</div><!-- row header-->
</div>	 <!--����� header-->

<?php If ($user_id > 0) {    

    //������� ����� ��� ������ �� ������� � ������   


    If (count($countPage)>=0) {
        echo "<div  class=\"container\" >";
        echo "<div class=\"row tablerow\">
   <table>
     <tr>  
        <th class='numberBS'>�����  <br> NE </th>
        	<th class='typePlace'>��� <br> ��������</th>
		<th class='adress'>�����</th>

        <th class='arendodatel'>������������</th>
		<th class='arendodatel'>���������</th>
		<th class='arendodatel'>���<br/>������</th>
        <th class='typeDogovor'>��� <br> ��������</th>
		<th class='numDogovor'>�����<br/>��������</th>
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

            if(!empty($data[$i]['number'])){
                $number_NE=$data[$i]['number'];
            }
            else {
                $number_NE='no_numb';
            }

            echo "<tr>";
//            echo "<td><center><b><a href='index.php?Id={$data[$i]['Id']}'>{$data[$i]['number']}</a></b></center></td>
            echo "<td><center><b><a href='index.php?Id={$data[$i]['Id']}'>{$number_NE}</a></b></center></td>
	  <td><center>".$data[$i]['type']."</center></td>
      <td>".$data[$i]['region'] . " �������  <br>". $data[$i]['area'] ." ����� <br>". $data[$i]['settlement'] ." <br> ". $data[$i]['adress']."</td>
      <td><center>".$data[$i]['arendodatel']."</center></td>
	  <td><center>".$data[$i]['arendator']."</center></td>
	  <td><center>".$data[$i]['type_arenda']."</center></td>
      <td><center>".$data[$i]['dogovor_type']."</center></td>
	  <td><center>".$data[$i]['dogovor_number']."</center></td>
	  <td><center>".date('d.m.Y',strtotime($data[$i]['dogovor_date']))."</center></td>
	  <td><center>".date('d.m.Y',strtotime($data[$i]['start_date_dogovor']))."</center></td>
	  <td><center>".$data[$i]['finish_date_dogovor']."</center></td>
	  <td><center>".$data[$i]['type_arenda']."</center></td>
	  <td><center>".$data[$i]['summa']." <br> ".$data[$i]['type_currency']."</center></td>";
	  If (!empty($data[$i]['nds2'])) {$cur = $data[$i]['type_currency'];}
	  echo "<td><center>".$data[$i]['nds2']." <br> ".$cur."</center></td>
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
            <div class="col-4 paginat ">

                <?php
                // ������� ������ � ������� ������� ��� ������������ ��������
                $array = [];
                for ($i=0; $i < $countPage; $i++){
                    array_push($array, $i);
                }
                // ������ � ��������� ��� �������
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

                if($Previous<0){
                    $Previous=$current;
                }

                if($Next>=$lastElement){
                    $Next=$lastElement;
                }
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
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$firstElement\"><sup style=\"color: #0275d8;\">$firstElement_d</sup><img src=\"https://img.icons8.com/color/15/000000/double-left.png\"/></a></li>";
                if($current_d != 1){
                echo " <li class=\"page-item\"><a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$Previous\">Previous </a></li>";};
                echo "       <li class=\"page-item active\">";
                echo "           <a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$current\">$current_d <span class=\"sr-only\"> </span></a>";
                echo "       </li>";
                if($current_d != $lastElement+1){
                echo " <li class=\"page-item\"><a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$Next\">Next </a></li>";};
                echo "       <li class=\"page-item\"><a class=\"page-link\" href=\"agreement_list.php?dog=".$dog_number."&page=$lastElement\"><img src=\"https://img.icons8.com/color/15/000000/double-right.png\"/><sup style=\"color: #0275d8;\">$lastElement_d</sup></a></li>";
                echo "   </ul>";
                echo "</nav>";
                ?>

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