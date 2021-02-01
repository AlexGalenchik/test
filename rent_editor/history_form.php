<?php ///////////////RENT ������� ������� ///////////////////////////

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
	$rights = '��������';
} else {
	$rights = '������';
}


// ������� ���������
$id = $_GET['id']; //Id ������� (� �������������� ������� ���������

$objects = array (
	'rent' => '�������'
   ,'number' => '����� �������'
   ,'dogovor_number' => '����� ��������'
);   
//�� ����� ������ objects ������ ��� ������ ���� ������� [�� ��� ������� ��� ������ �������]
//������������ ������ $objects � ����� ������ $fields � �������� ������ ������ ����� �� ���������� 
//([budget,budget_addresses][bts,sectors,rrl,hardware],[repeaters,repeater_sectors])
foreach ($objects as $key => $value) {
  $fields[] = '"'.$key.'"';
}
//������ �� ������� ������ �� ������� ������� (history)
$sql = "SELECT ";
$sql.= " act_date";
$sql.= ",act_time";
$sql.= ",surname";
$sql.= ",name";
$sql.= ",middle_name";
//$sql.= ",action";
$sql.= ",rent.type as type"; // ��� �������
$sql.= ",rent.dogovor_number as dog_number"; // ��� �������
$sql.= ",rent.number as object_number"; //����� ������� - ��, �������, ����,....
$sql.= ",changes"; //�������� ��������� 
$sql.= ",table_name";
$sql.= " FROM history_rent"; 
$sql.= " LEFT JOIN users"; //������ � �������� �������������
$sql.= " ON history_rent.user_id=users.Id";
$sql.= " LEFT JOIN rent"; //������ � �������� �������������
$sql.= " ON history_rent.object_id=rent.Id";
$sql.= " WHERE table_name like 'rent' AND object_id=$id ORDER BY history_rent.Id DESC"; //��������� ������ � ���� �� �������� ","
//��� ���� table_name  � ������� ������� ������ $fields (����� �� ��������) � ���� object_id ����� id ������� (��� ������� ��� ������ �������)
//���������� �� �������� ������� � ������� �������, �.�. ���������� ������ ����� ������ ������

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
    <title>������� <?php echo $row['type']." ".$row['object_number']; ?></title>
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

    <!-- ����� header-->
	<div id="cap" class="container mt-1" >
		<div class="row align-self-center" >
			<div class="col-12" >
					<div  class="container" >	
						<div class="row align-items-center">
                            <div class="col-md-9">
                                <div class="row align-items-center ">
                                    <div class="col-md-3 arend">
                                        <a href="/rent/index.php?Id=<?php echo $id; ?>"><button type="button" class="btn btn-danger" >�����</button></a>
                                    </div>
                                    
                                </div>
                            </div>

						    <div class="col-md-3" >
                                <div class="row align-items-center">
                                    <!-- ����� ����������� -->
                                    <?php
									session_start();
                                    // ���� ����� �����������
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
                                                                          <a href='logout.php'><button >�����</button></a>
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
	
	
<?php	
	
echo "<div  class='container mt-2'>";
// ����� ��������� ����������
echo "<div id='history'>";
echo "<table>";   // ������� �������
echo "<tr>";// ����� ������� �������
echo "<th>����</th>"; //act_date
echo "<th>�����</th>"; //act_time
echo "<th>�������.</th>"; //surname name middle_name
echo "<th>������</th>"; //table_name
//echo "<th>��� �������</th>"; //table_name
echo "<th>����� �������</th>"; //table_name
echo "<th>������� �</th>"; //table_name
//echo "<th>��������</th>"; //action
echo "<th>���������</th>";  //changes
echo "</tr>";

for ($i=0; $i<mysql_num_rows($query); $i++) { //����� ������ �� ������� history
  $row = mysql_fetch_array($query);
  echo "<tr>";
  echo "<td>".$row['act_date']."</td>"; // ���� ���������
  echo "<td>".$row['act_time']."</td>"; // ����� ���������
  $user = $row['surname']." ".(!empty($row['name'])? substr($row['name'],0,1).'.' : '').(!empty($row['middle_name'])? substr($row['middle_name'],0,1).'.' : '');
  //����������� ������������ �� ������� "������� �.�." ���� ��� � �������� ���� � ����
  echo "<td>$user</td>"; //����� "������� �.�."
  $object = $objects['rent']; //��� ������� (��,������,�������)
  echo "<td>".$row['type']."</td>"; //����� �������
  //echo "<td>$id</td>"; //����� ������� id
  echo "<td><b>".$row['object_number']."</b></td>"; //����� ������ �������
  //if ($row['action'] == 'insert') $action = "��������� ������"; // ������� ���� �� �������
  //if ($row['action'] == 'update') $action = "�������� ������";// ������� ���� �� �������
  //if ($row['action'] == 'delete') $action = "������� ������";  // ������� ���� �� �������
  echo "<td>".$row['dog_number']."</td>"; //����� �������� ��� ��������
  //echo "<td>$action</td>"; //����� �������� ��� ��������
  echo "<td>";
  $changes = explode(';',$row['changes']); //��������� ������ �� ���������� � ������� ����������� � ������ ������ ";" � ���������� � ������ $changes
  for ($j=0; $j<count($changes); $j++) {
	 echo $changes[$j]; //����� ���������� (����� ������) �� ������� ��������� $changes, ����������� ";"
	     
    if ($j+1 < count($changes) ) echo"<br>"; //������� �� ����� ������ ��� ������ ����� ����������
  }
  echo "</td>";
  echo "</tr>";
}

echo "</table>"; //��������� �������
echo "</div>";

} else {
	echo "������ � ������� ��������� ���!!!";
}
echo "</div>";
?> 