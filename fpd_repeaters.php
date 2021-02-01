<?php
	session_start();
	include_once('config.php');
	include_once('functions.php');
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>�������� ��� �������</title>
</head>
<body>
<h3>������� ���� ������ � ����� ������� �������� ��� (���������)</h3>
<form action="" method="POST">
<label><b>������:</b></label><br/>
	<input type="date" name="start_date" value="<?php echo $_POST['start_date']; ?>"><br/><br/>
<label><b>�����:</b></label><br/>	
	<input type="date" name="finish_date" value="<?php echo $_POST['finish_date']; ?>"><br/><br/>
	<button type="submit" name="submit" ><b>�����</b></button>
	<br/><br/>
	<a href="loadExcelRep.php" target="_blank" ><button type="button" style="border-radius:5px;"><img src="pics/excel_button.jpeg" width="20px"> <b>���������</b></button></a>
</form>
</body>
</html>
<?php //������������ ������� � �� ��� �������� ������ �� ���
$start_date = $_POST['start_date'];
$finish_date = $_POST['finish_date'];

$_SESSION['start_date'] = $start_date;
$_SESSION['finish_date'] = $finish_date;

//�������� �� ������������ ��������� ���
$today = date("Y-m-d");
If ($finish_date <= $today) { // �������� �� ������������ ����
	
If (!empty($start_date) && !empty($finish_date)){
//������������ ������� � �� � �������� ��� ����� � �����
$sql = " SELECT";
$sql.= "  repeaters.Id";
$sql.= " ,repeaters.repeater_number";
$sql.= " ,repeaters.inventory_number"; // ��������� ��� ������� �������� �.�.
$sql.= " ,repeaters.date_rep_insert_expl"; // ��������� ��� ������� �������� �.�.
$sql.= " ,formulars.type as formular_type";
$sql.= " ,repeater_types.repeater_type";
$sql.= " ,repeater_types.diapazon";
$sql.= " ,regions.region";
$sql.= " ,areas.area";
$sql.= " ,settlements.type as settlement_type";
$sql.= " ,settlements.settlement";
$sql.= " ,repeaters.street_type";
$sql.= " ,repeaters.street_name";
$sql.= " ,repeaters.house_type";
$sql.= " ,repeaters.house_number";
$sql.= " ,repeaters.place_owner";
$sql.= " ,formulars.create_date";
$sql.= " ,formulars.to_lotus_date";
$sql.= " ,formulars.signed_date";
$sql.= "  FROM repeaters";
$sql.= "  LEFT JOIN repeater_types";
$sql.= "  ON repeater_types.Id = repeaters.repeater_type_id";
$sql.= "  LEFT JOIN settlements";
$sql.= "  ON settlements.Id = repeaters.settlement_id";
$sql.= "  LEFT JOIN areas";
$sql.= "  ON areas.Id = settlements.area_id";
$sql.= "  LEFT JOIN regions";
$sql.= "  ON regions.Id = areas.region_id";
$sql.= "  LEFT JOIN power_types";
$sql.= "  ON power_types.Id = repeaters.power_type_id";
$sql.= "  LEFT JOIN formulars";
$sql.= "  ON formulars.repeater_id = repeaters.Id";
$sql.= "  WHERE formulars.create_date BETWEEN '".$start_date."' AND '".$finish_date."'";
$sql.= "  ORDER BY formulars.create_date";
$query = mysql_query($sql) or die(mysql_error());

$count = mysql_num_rows($query);

echo "<br/>";
echo "<b>������� <span style=\"color:red;font-weight:bold;font-size:16px;\">".$count."</span> ���������</b><br/>";

If (mysql_num_rows($query) >0) {
  echo "<div>";
  echo "<table id='result_table'>";
  echo "<tr align='center'>";  // ���������
  echo "<td id='rs_td'><b>�������</b></td>";
  echo "<td id='rs_td'><b>���<br/>���������</b></td>";
  echo "<td id='rs_td'><b>�������</b></td>";
  echo "<td id='rs_td'><b>�����</b></td>";
  echo "<td id='rs_td'><b>���. �����</b></td>";
  echo "<td id='rs_td'><b>�����</b></td>";
  echo "<td id='rs_td'><b>����������</b></td>";
  //echo "<td id='rs_td'><b>���<br/>��������</b></td>";
  echo "<td id='rs_td'><b>����������</b></td>";
  //echo "<td id='rs_td' style=\"width: 100px;\"><span style=\"color:green;font-weight:bold;\">�����������<br/>�����</span></td>"; // ��������� ��� ������� �������� �.�.
  echo "<td id='rs_td' style=\"width: 65px;\"><span style=\"color:green;font-weight:bold;\">���� ����� �<br/>������������</span></td>"; // ��������� ��� ������� �������� �.�.
  echo "<td id='rs_td' style=\"width: 70px;\"><b>���<br/>������</b></td>";
  echo "<td id='rs_td' style=\"width: 70px;\"><b>���<br/>������</b></td>";
  echo "<td id='rs_td' style=\"width: 70px;\"><b>���<br/>���������</b></td>";
  echo "</tr>";
  for ($i=0; $i<mysql_num_rows($query); $i++) {
    $row = mysql_fetch_array($query);
	//$k = $i+1;
	//If ($i < mysql_num_rows($query)) { // ������ ��������� ������ �������
	echo "<tr>";
	echo "<td id='rs_td'><a href='redirect.php?f=30&id=".$row['Id']."' target='_blank'><span style=\"color:blue;font-weight:bold;\"><center>".$row['repeater_number']."</center></span></a></td>";
	//echo "<td id='rs_td'>&nbsp;".$k."</td>";
    echo "<td id='rs_td'><center>".$row['formular_type']."</center></td>";
    echo "<td id='rs_td'><center>".$row['region']."</center></td>";
    echo "<td id='rs_td'><center>".$row['area']."</center></td>";
    echo "<td id='rs_td'><center>".$row['settlement']."</center></td>";
	echo "<td id='rs_td'>".FormatAddress('','',$row['street_type'],$row['street_name'],$row['house_type'],$row['house_number'],'','')."</center></td>";
    echo "<td id='rs_td' >".$row['place_owner']."</center></td>";
	//echo "<td id='rs_td'>".$row['repeater_type']."</td>";
	echo "<td id='rs_td'>".$row['diapazon']."</td>";
	//echo "<td id='rs_td'><center>".$row['inventory_number']."</center></td>"; // ��������� ��� ������� �������� �.�.
	echo "<td id='rs_td'><center>".$row['date_rep_insert_expl']."</center></td>"; // ��������� ��� ������� �������� �.�.
	echo "<td id='rs_td'><center>".$row['create_date']."</center></td>";
	echo "<td id='rs_td'><center>".$row['to_lotus_date']."</center></td>";
	echo "<td id='rs_td'><center>".$row['signed_date']."</center></td>";
	echo "</tr>";
	//}
  } 
  echo "</table>";
  echo "</div>";
}
//echo "<br/>������� <span style=\"color:red;font-weight:bold;font-size:16px;\">".($i)."</span> ���������<br/>";

} 
} else {
	echo "<br/></br/><b>�� ����� �������� ���� ���������!<br/>������� - ".$today."</b>";
} 




?>