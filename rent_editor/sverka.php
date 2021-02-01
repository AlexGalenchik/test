<?php
include_once('/core/config.php');
include_once('/core/function.php');
include_once('../config.php');
session_start();

$conn = connect(); // ����������� � ��
 
 //�������, ������� ��������� ������ �� ���������� �������� ������� ��������
 Function make_array ($table,$column,$conn,$column3) {
	 
	$sql = "SELECT DISTINCT $column FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE  $column3 like '��� ��������'";
		}
		$sql .= " ORDER BY $column";
	 
	$query =  mysqli_query($conn, $sql);
	
	$a = [];
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i<mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[] = $row[$column];
			
	}
	return $a; 
	 
}

 

//������� ��������� ������ �� ���������� �������� �� � ��������
 Function make_array2 ($table,$column1,$column2, $conn, $column3) {
	 
	$sql = "SELECT DISTINCT $column1, $column2 FROM $table";
		if($column3 !== '') {
	$sql .=	" WHERE  $column3 like '��� ��������'";
		}
		$sql .= " ORDER BY $column1";
	 
	 
	$query =  mysqli_query($conn, $sql);
	
	$a = [];
	// ������ ������ �������� �� ���� � ������ DATA
	For ($i = 0; $i < mysqli_num_rows($query);$i++) {
		$row = mysqli_fetch_assoc($query);
		$a[$row[$column1]] = $row[$column2];
 
			
	}
	return $a; 
	 
}

///////////////////////////////////////////////////////////////////
//������������ ������� ������� �������� �� ���������� ����� �������

//������� ������ ���������� ������� �� � ������� ������� ����
$emkost = make_array ('emkost_seti','bts_number',$conn,'');

//������� ������ ���������� ������� �� � ������� �� ������� ����
$emkost2 = make_array2 ('emkost_seti','bts_number','adress',$conn,'');

//������� ������ ��������� �� �� ������� ����
$emkost_PBS = [7001,7002,7004,8001,8002,8003,2000,2001,2002,2003,2004,2005,2006,2007];

//������������ ������� ������� �������� �� �� RENT

$rent = make_array ('rent','number',$conn, 'type_arenda');

//������������ ������� ������� �������� �� �����

$land = make_array ('land_docs_minsk','bts',$conn,'');

//������ $nedostatok �������� �������� ������� �� ����� �������, ������� �� ����� � �� rent � � �� Land � � ������ ��������� �� (��� �� ��������� ��� ������)

$nedostatok = array_diff($emkost,$rent,$land,$emkost_PBS);

$_SESSION['nedostatok'] = count($nedostatok); //��� ������ ������ �� ���������� ��������� ��������
 
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--         <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />-->
    <title>�� ��������� �������</title>
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


<div id="cap" class="container mt-1" ><!-- ����� header-->
    <div class="row align-self-center" ><!-- row header-->
        <div class="col-12" > <!-- row col-12 -->
            <div  class="container" > <!-- 2 container -->
                <div class="row align-items-center"><!-- row 2 -->
                    <div class="col-md-3 push-9" >
					
                      
                    </div>


                    <div class="col-md-9 pull-3">
					
					 <div class="col-md-5 ">
                                        <a href="../main.php"><button type="button" class="btn btn-danger">�����</button></a>
										<?php IF ($_SESSION['user_login'] == 'alex' || $_SESSION['user_login'] == 'pusharov') {?>
											<a href="/rent/sent.php"><button type="button" class="btn btn-danger" title="�������� �� ������ ��������� �� 3 �������">����������� �� E-mail</button></a>
										<?php } ?>
                                    </div>
					
                                        
									
					
					<h4>�� ��������� ������� � ���� - <?php echo count($nedostatok); ?> �� (������ 2021�.)</h4>
				 
					
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
        echo "<div  class=\"container\" >"; // ����� �������
        echo "<div class=\"row tablerow\">";
$k=0;

echo "<table>";
echo "<tr>
	  <th class='num_naideno'><b>�<b></th>
	  <th class='bts_naideno'><b>����� ��<b></th>
	  <th class='adress_naideno'>����� �������</th>
	  <th class='reasons'>�������<br/>���������� � ��</th>
	  <th class='meri'>�����������<br/>��� �������</th>
	  <th class='sroki'>����<br/>����������</th>
	  <th class='redactor'>�������������</th><tr>";
	 
	  
foreach($nedostatok as $value) {
	
	if(array_key_exists($value, $emkost2)) {
		$k++;
		// ����� ������ �� �������� �� � ������� DELTA_INFO
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
			
		
		// ����� �� ����� ���������� ������� DELTA_SVERKA
		echo "<tr>
		<td span style=\"padding: 5px;\">".$k."</td>
		<td span style=\"padding: 5px;font-size: 14px;\"><a href='sverka_edit.php?bts_num=".$value."'><b>".$value."</b></a></td>
		<td span style=\"padding: 5px;text-align:left;\">".$emkost2[$value]."</td>
		<td span style=\"padding: 5px;text-align:left;\">".$reason."</td>
		<td span style=\"padding: 5px;text-align:left;\">".$events."</td>
		<td span style=\"padding: 5px;\">".$srok."</td>
		<td span style=\"padding: 5px;\">".$ispolnitel."</td></tr>";
		
		
		//������ � ������� Delta ����������� ���������� ������
	//1. �������� �� ������� ���� �� � ������� DELTA_SVERKA (���� ����� �� ���� - �� ��� �� ���������)
		$sql_search = "SELECT `bts_num` FROM `delta_sverka` WHERE `bts_num` like '".$value."' ";
		$result = mysqli_query($conn,$sql_search);
		if (mysqli_num_rows($result) > 0) {
			//���� ����� �� ��� ���� � ������� DELTA_SVERKA, �� �� �� ������ � ���������� ���� ��� �����
			continue; 
		} else { 
			//���� ����� �� ��� � ������� Delta, �� �� ������ � ������� DELTA_SVERKA
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