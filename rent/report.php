<?php
include_once('../config.php');
include_once('./core/function.php');
session_start();

If ($_SESSION['rights'] == 'w') {
	$rights = '��������';
} else {
	$rights = '������';
}


?>
<!DOCTYPE html>
<html>
<head> 
    <!--<meta http-equiv="Content-Type" content="text/html; charset=windows-1251 " /> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />
    <title>������ - ��������</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://shop.mts.by/favicon.ico" />
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="Style.css">
    <style type="text/css">
   #table_counter {
		float: left; 
		border: 1px solid red; 
		padding: 2px; 
		margin: 3px; 
		text-align: center;
		font-size:  12px;
		font-family: 'Times New Roman';
		width: 240px;
		height: 265px;
		border-collapse: collapse; 
		border-radius: 4px;
		box-shadow: 0 0 10px rgba(0,0,0,0.7);
		overflow: auto;
		}
	table, td {
		border: 1px solid grey;
		border-collapse: collapse; 
		padding: 2px;
		width: 230px;
		vertical-align: middle;
		}
	#table_head {
		float: left;
		background-color: orange;		
		border: 1px solid red; 
		
		margin: 3px; 
		text-align: center;
		font-size:  14px;
		font-family: 'Times New Roman';
		width: 240px;
		height: 25px;
		border-collapse: collapse; 
		border-radius: 4px;
		box-shadow: 0 0 10px rgba(0,0,0,0.7);
				}
	</style>
</head>
<body>
<!-- ����� header-->
<div id="cap" class="container mt-1" >
    <div class="row align-self-center" >
        <div class="col-12" >
            <div  class="container" >
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <div class="row align-items-center ">
                            <div class="col-md-4 arend">
                                <a href="/rent/geo_finder.php"><button type="button" class="btn btn-danger" >�����</button></a>
                            </div>
                            <div class="col-md-4">
                                <!--                                        <input class="btn btn-primary" type="submit"  value="��������">-->
<!--                                <a href="/rent/edit.php?Id=--><?php //echo $_GET['Id'];  ?><!--"><button type="button" class="btn btn-danger" >��������</button></a>-->
                            </div>
                            <div class="col-md-4">
<!--                                <a href="/rent/new_bs.php"><button type="button" class="btn btn-danger" >NEW ��������</button></a>-->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3" >
                        <div class="row align-items-center">
                            <!-- ����� ����������� -->
             <?php
			 
			
                            // ���� ����� �����������
                            if ($_SESSION['user_id'] == 0) {
                                include('/login_form.php');
                            }
                            if ($_SESSION['user_id'] > 0) {
                                echo  "
                                                            <div class=\"col-8\">
                                                                    <div class='col log_info'>
                                                                         ". $_SESSION['user_surname'] ." 
                                                                         ". $_SESSION['user_name']."
                                                                         ". $_SESSION['middle_name'] ."
																		 [". $_SESSION['reg_user'] ."]
																		 [". $rights ."]																		 
                                                                    </div>
                                                               <div class=\"w-100\"></div>
                                                                    <div class='col'>
                                                                          <a href='/rent/logout.php'><button >�����</button></a>
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
                    </div>		<!-- ����� ����� ����������� -->

                </div>
            </div>
        </div>
    </div>
</div>	 <!--����� header-->

	<div id="cap" class="container" ><!-- ����� header-->
		   <div class="row align-self-center" ><!-- row header-->
				 
			</div>
	</div>


<?php

include_once('../functions.php');


/////////////////////������� ������������� ��������
function Payment ($reg,$type) {
	IF ($reg) {
		If ($reg !== '��������' ) { //���� ������ ������ �� ����������� ������
			$sql = "SELECT";
			$sql.= " SUM(rent_pay_BYN) as SUM_rent_pay_BYN";
			$sql.= ",SUM(rent_pay_BAV) as SUM_rent_pay_BAV";
			$sql.= ",SUM(rent_pay_BV) as SUM_rent_pay_BV";
			$sql.= ",SUM(rent_pay_EUR) as SUM_rent_pay_EUR";
			$sql.= ",SUM(rent_pay_USD) as SUM_rent_pay_USD";
			$sql.= ",SUM(summa) as SUM_summa";
			$sql.= " FROM rent";
			$sql.= " WHERE division like '".$reg."'"; //`region` �������� �� 'division'
			$sql.= " AND type_arenda like '".$type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		} else {
			$sql = "SELECT";
			$sql.= " SUM(rent_pay_BYN) as SUM_rent_pay_BYN";
			$sql.= ",SUM(rent_pay_BAV) as SUM_rent_pay_BAV";
			$sql.= ",SUM(rent_pay_BV) as SUM_rent_pay_BV";
			$sql.= ",SUM(rent_pay_EUR) as SUM_rent_pay_EUR";
			$sql.= ",SUM(rent_pay_USD) as SUM_rent_pay_USD";
			$sql.= ",SUM(summa) as SUM_summa";
			$sql.= " FROM rent";
			$sql.= " WHERE type_arenda like '".$type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		}
	}
	
	$arr = array ( //round - ���������� ����� �� ������� ����� ����� �������
	
    'BYN' => round($row['SUM_rent_pay_BYN'],2,PHP_ROUND_HALF_UP) 
   ,'BAV' => round($row['SUM_rent_pay_BAV'],2,PHP_ROUND_HALF_UP)
   ,'BV' => round($row['SUM_rent_pay_BV'],2,PHP_ROUND_HALF_UP)
   ,'EUR' => round($row['SUM_rent_pay_EUR'],2,PHP_ROUND_HALF_UP)
   ,'USD' => round($row['SUM_rent_pay_USD'],2,PHP_ROUND_HALF_UP)
   ,'summa' => round($row['SUM_summa'],2,PHP_ROUND_HALF_UP)
   
   );
   
   $arr_new = array();
   
   foreach ($arr as $key => $value) {
	   If ($value > 0) {
		   $arr_new [$key] = $value;
	   }
   }

   return $arr_new;
   
   
}
//////////////////////////////////������� ������������ ���������� ���������
function Room_Cables ($reg,$type) {
	IF ($reg) {
		If ($reg !== '��������' ) { //���� ������ ������ �� ����������� ������
			$sql = "SELECT";
			$sql.= " SUM(room_area) as SUM_room_area";
			$sql.= ",SUM(roof_area) as SUM_roof_area";
			$sql.= ",SUM(asphalt_pad_area) as SUM_asphalt_pad_area";
			$sql.= ",SUM(length_cable) as SUM_length_cable";
			$sql.= " FROM rent";
			$sql.= " WHERE division like '".$reg."'";      //`region` �������� �� 'division'
			$sql.= " AND type_arenda like '".$type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		} else {
			$sql = "SELECT";
			$sql.= " SUM(room_area) as SUM_room_area";
			$sql.= ",SUM(roof_area) as SUM_roof_area";
			$sql.= ",SUM(asphalt_pad_area) as SUM_asphalt_pad_area";
			$sql.= ",SUM(length_cable) as SUM_length_cable";
			$sql.= " FROM rent";
			$sql.= " WHERE type_arenda like '".$type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		}
	}
	
	$arr = array ( //round - ���������� ����� �� ������� ����� ����� �������
	
    '������� ����' => round($row['SUM_room_area'],2,PHP_ROUND_HALF_UP) 
   ,'������� ������' => round($row['SUM_roof_area'],2,PHP_ROUND_HALF_UP)
   ,'������� ��������' => round($row['SUM_asphalt_pad_area'],2,PHP_ROUND_HALF_UP)
   ,'����� ������' => round($row['SUM_length_cable'],2,PHP_ROUND_HALF_UP)
    );
	
		$arr_new = array();
   
   foreach ($arr as $key => $value) {
	   If ($value > 0) {
		   $arr_new [$key] = $value;
	   }
   }

   return $arr_new;

   
	
}
/////////////////������� ������������ �� ���� ������������ (FTTX, ��, �������, ����, WI-FI, ����������, �����
function TypeHW ($reg,$type,$hw_type) {
	IF ($reg) {
		If ($reg !== '��������' ) { //���� ������ ������ �� ����������� ������
			$sql = "SELECT";
			$sql.= " count(*) as SUM_HW";
			$sql.= " FROM rent";
			$sql.= " WHERE division like '".$reg."'";      //`region` �������� �� 'division'
			$sql.= " AND type_arenda like '".$type."'";
			$sql.= " AND type like '".$hw_type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		} else {
			$sql = "SELECT";
			$sql.= " count(*) as SUM_HW";
			$sql.= " FROM rent";
			$sql.= " WHERE type_arenda like '".$type."'";
			$sql.= " AND type like '".$hw_type."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		}
	}
	
	$arr = array ( //round - ���������� ����� �� ������� ����� ����� �������
	
    $hw_type => $row['SUM_HW'] 
    );
	
	$arr_new = array();
   
   foreach ($arr as $key => $value) {
	   If ($value > 0) {
		   $arr_new [$key] = $value;
	   }
   }

   return $arr_new;

   
}

/////////////////////������� ������������� �������� �� �����������
function Payment_Ispolnitel ($reg,$type,$lico) {
	IF ($reg) {
		If ($reg !== '��������' ) { //���� ������ ������ �� ����������� ������
			$sql = "SELECT";
			$sql.= " SUM(rent_pay_BYN) as SUM_rent_pay_BYN";
			$sql.= ",SUM(rent_pay_BAV) as SUM_rent_pay_BAV";
			$sql.= ",SUM(rent_pay_BV) as SUM_rent_pay_BV";
			$sql.= ",SUM(rent_pay_EUR) as SUM_rent_pay_EUR";
			$sql.= ",SUM(rent_pay_USD) as SUM_rent_pay_USD";
			$sql.= ",SUM(summa) as SUM_summa";
			$sql.= " FROM rent";
			$sql.= " WHERE division like '".$reg."'";		//`region` �������� �� 'division'
			$sql.= " AND type_arenda like '".$type."'";
			$sql.= " AND ispolnitel like '".$lico."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		} else {
			$sql = "SELECT";
			$sql.= " SUM(rent_pay_BYN) as SUM_rent_pay_BYN";
			$sql.= ",SUM(rent_pay_BAV) as SUM_rent_pay_BAV";
			$sql.= ",SUM(rent_pay_BV) as SUM_rent_pay_BV";
			$sql.= ",SUM(rent_pay_EUR) as SUM_rent_pay_EUR";
			$sql.= ",SUM(rent_pay_USD) as SUM_rent_pay_USD";
			$sql.= ",SUM(summa) as SUM_summa";
			$sql.= " FROM rent";
			$sql.= " WHERE type_arenda like '".$type."' ";
			$sql.= " AND ispolnitel like '".$lico."'";
			$query = mysql_query ($sql) or die (mysql_error());
			$row = mysql_fetch_assoc ($query);
		}
	}
	
	$arr = array ( //round - ���������� ����� �� ������� ����� ����� �������
	
    $lico.' BYN' => round($row['SUM_rent_pay_BYN'],2,PHP_ROUND_HALF_UP) 
   ,$lico.' BAV' => round($row['SUM_rent_pay_BAV'],2,PHP_ROUND_HALF_UP)
   ,$lico.' BV' => round($row['SUM_rent_pay_BV'],2,PHP_ROUND_HALF_UP)
   ,$lico.' EUR' => round($row['SUM_rent_pay_EUR'],2,PHP_ROUND_HALF_UP)
   ,$lico.' USD' => round($row['SUM_rent_pay_USD'],2,PHP_ROUND_HALF_UP)
   ,$lico.' summa' => round($row['SUM_summa'],2,PHP_ROUND_HALF_UP)
     
   );
   
   $arr_new = array();
   
   foreach ($arr as $key => $value) {
	   If ($value > 0) {
		   $arr_new [$key] = $value;
	   }
   }

   return $arr_new;
   
    	
}


////////////////////////////////////����� ������ � �������� �� ������

echo " <div class='container' >"; 
echo " <div class='row align-self-center' > ";

?>

 
				 <div class="col-4 push-4">
					<br/>
						<form action="" method="post">
							<select class="reg" name="region" >
							<option value="<?php echo $_POST['region'];?>"><?php echo $_POST['region'];?></option>
								<option value=""></option>
								<option value="���������">���������</option>
								<option value="���������">���������</option>
								<option value="����������">����������</option>
								<option value="�����������">�����������</option>
								<option value="�����������">�����������</option>
								<option value="����">����</option>    <!-- ������� �������� �� ���� -->
								<option value="��������">��������</option>
								
								
							</select>
							<input type="submit" name="reg_submit" type="button" value="�������">
						</form>
					<br/>
				</div>
				
				 
			
			<div class="w-100"></div>
			
<?php


if ($_SESSION['user_id'] > 0) { ////�������� ��������� �� ������������. ���� ��� - �� ������ �� �������

$region = $_POST['region'];
//////////////////////////////////���� ������ �� ������
echo "<div class='col push-2'>";
echo "<div id='table_head'>";
echo "<td colspan='2'><b>��� �������� ���</b></td>";
echo "</div>";

echo "<div id='table_head'>";
echo "<td colspan='2'><b>��� �����</b></td>";
echo "</div>";

echo "<div id='table_head'>";
echo "<td colspan='2'><b>��� �������� �����</b></td>";
echo "</div>";

echo "</div>";

echo "<div class='w-100'></div>";

//////////////////////////////���� � �������

echo "<div class='col push-2'>";
echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>������� �� ������</b></th>";
foreach (Payment ($region,'��� �������� ���') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>������� �� ������</b></th>";
foreach (Payment ($region,'��� �����') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>������� �� ������</b></th>";
foreach (Payment ($region,'��� �������� �����') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";
echo "</div>";


echo "<div class='w-100'></div>";

///////////////////////////////////////////����� ������ � ���������� �������� ��������� � ����� ������
echo "<div class='col push-2'>";
echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>�������, �����, ������</b></th>";
foreach (Room_Cables ($region,'��� �������� ���') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>�������, �����, ������</b></th>";
foreach (Room_Cables ($region,'��� �����') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>�������, �����, ������</b></th>";
foreach (Room_Cables ($region,'��� �������� �����') as $key => $value) {
    	echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
	}
echo "</table></div>";
echo "</div>";
echo "<div class='w-100'></div>";

///////////////////////////////////////////����� ������ � ���������� ��������� ��� ������� ���� ������������
$sql_types = "SELECT DISTINCT type FROM rent";
$query = mysql_query ($sql_types) or die (mysql_error());

$types = array ();

for ($i=0;$i<mysql_num_rows($query);$i++) {
	$row = mysql_fetch_assoc ($query);
	$types[] = $row;
}

echo "<div class='col push-2'>";
echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>�� ���� ������������</b></th>";
FOR ($k=0;$k<count($types);$k++) {
	If ($types[$k][type] !== Null) {
		foreach (TypeHW ($region,'��� �������� ���',$types[$k][type]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>�� ���� ������������</b></th>";
FOR ($k=0;$k<count($types);$k++) {
	If ($types[$k][type] !== Null) {
		foreach (TypeHW ($region,'��� �����',$types[$k][type]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>";

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>�� ���� ������������</b></th>";
FOR ($k=0;$k<count($types);$k++) {
	If ($types[$k][type] !== Null) {
		foreach (TypeHW ($region,'��� �������� �����',$types[$k][type]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>";
echo "</div>";
echo "<div class='w-100'></div>";

//////////////////////////////�������� �� ������������� ����
///////////////////////////////////////////����� ������ � ���������� ��������� ��� ������� ���� ������������
$sql_ispolnitel = "SELECT DISTINCT ispolnitel FROM rent";
$query = mysql_query ($sql_ispolnitel) or die (mysql_error());

$ispolnitels = array ();

for ($i=0;$i<mysql_num_rows($query);$i++) {
	$row = mysql_fetch_assoc ($query);
	$ispolnitels[] = $row;
}
echo "<div class='col push-2'>";
echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>������� ������ (���������)</b></th>";
FOR ($k=0;$k<count($ispolnitels);$k++) {
	If ($ispolnitels[$k][ispolnitel] !== Null) {
		foreach (Payment_Ispolnitel ($region,'��� �������� ���',$ispolnitels[$k][ispolnitel]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>"; 

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>������� ������ (���������)</b></th>";
FOR ($k=0;$k<count($ispolnitels);$k++) {
	If ($ispolnitels[$k][ispolnitel] !== Null) {
		foreach (Payment_Ispolnitel ($region,'��� �����',$ispolnitels[$k][ispolnitel]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>"; 

echo "<div id='table_counter'>";
echo "<table>";
echo "<th colspan='2'><b>������� ������ (���������)</b></th>";
FOR ($k=0;$k<count($ispolnitels);$k++) {
	If ($ispolnitels[$k][ispolnitel] !== Null) {
		foreach (Payment_Ispolnitel ($region,'��� �������� �����',$ispolnitels[$k][ispolnitel]) as $key => $value) {
			echo "<tr><td>".$key."</td><td><b>".$value."</b></td></tr>";	
		}
	}
}	
echo "</table></div>"; 
echo "</div>";

}
?>



</div>		
</body>
</html>